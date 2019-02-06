<?php

namespace App\Console\Commands;

use Mail;
use App\Contact;
use App\ContactRelationship;
use App\Address;
use App\User;
use App\AddressContact;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class UploadContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:contacts {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload contacts given CSV file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Uploading contacts from " . $this->argument('filepath') . "...\n\n";

        $handle = fopen($this->argument('filepath'), "r");
        $header = true;
        $created_count = 0;
        $updated_count = 0;
        $skipped_count = 0;
        $error_count = 0;
        $line_number = 0;

        $sbs_name_to_user = [
            'bob' => 1,
            'jason' => 13,
            'mike' => 7,
            'josh' => 1952
        ];

        $row_num = 1;
        while (($row = fgetcsv($handle, ",")) !== false) {
            $row_num++;

            if ($header) {
                $header = false;
                continue;
            }

            $row_size = count($row);
            $email = $row[7];

            if (!$email || strlen($email) == 0) {
                echo "Email required. Missing on row ".$row_num.".\n";
                continue;
            }

            $contact = Contact::where('email', '=', $email)->get();
            if (count($contact) > 0) {
                echo $email . " already exists.\n";
                // TODO Update?
                $skipped_count += 1;
                continue;
            }

            $sbs_reps = array();
            if ($multi_rep = explode('/', $row[0])) {
                foreach ($multi_rep as $rep) {
                    $sbs_reps[] = strtolower($rep);
                }
            }
            $sbs_reps[] = (($row[1] !== "") ? strtolower($row[1]) : null);
            $sbs_reps[] = (($row[2] !== "") ? strtolower($row[2]) : null);

            $args = array(
                'organization' => (($row[3] !== "") ? $row[3] : null),
                'first_name'   => (($row[4] !== "") ? $row[4] : null),
                'last_name'    => (($row[5] !== "") ? $row[5] : null),
                'title'        => (($row[6] !== "") ? $row[6] : null),
                'email'        => (($row[7] !== "") ? $row[7] : null),
                'phone'        => (($row[8] !== "") ? $row[8] : null),
                'line_one'     => (($row[9] !== "") ? $row[9] : null),
                'city'         => (($row[10] !== "") ? $row[10] : null),
                'state'        => (($row[11] !== "") ? $row[11] : null),
                'postal_code'  => (($row[12] !== "") ? $row[12] : null),
                'country'      => (($row[13] !== "") ? $row[13] : null),
                'sbs_reps'     => $sbs_reps
            );

            $contact = DB::transaction(function() use($args, $line_number, $sbs_name_to_user) {
                $contact = Contact::create([
                    'first_name' => $args['first_name'],
                    'last_name' => $args['last_name'],
                    'email' => $args['email'],
                    'phone' => $args['phone'],
                    'title' => $args['title'],
                    'organization' => $args['organization'],
                    'job_seeking_status' => null,
                    'job_seeking_type' => null,
                ]);

                $address = Address::create([
                   'line1' => $args['line_one'],
                   'line2' => null,
                   'city' => $args['city'],
                   'state' => $args['state'],
                   'postal_code' => $args['postal_code'],
                   'country' => $args['country']
                ]);

                $address_contact = AddressContact::create([
                   'address_id' => $address->id,
                   'contact_id' => $contact->id
                ]);

                foreach ($args['sbs_reps'] as $name) {
                    if (is_null($name)) {
                        continue;
                    }
                    if (array_key_exists($name, $sbs_name_to_user)) {
                        $user_id = $sbs_name_to_user[$name];
                        $existing = ContactRelationship::where('contact_id', '=', $contact->id)
                            ->where('user_id', '=', $user_id)->get();
                        if (count($existing) < 1) {
                            $contact_relationship = ContactRelationship::create([
                                'contact_id' => $contact->id,
                                'user_id' => $user_id
                            ]);
                        }
                    } else {
                        echo "Invalid SBS Rep (".$name.") on row ".$row_num."\n";
                    }
                }

                return $contact;
            });

            if (!is_null($contact)) {
                $created_count += 1;
            } else {
                echo "Error creating contact on row ".$row_num."\n";
                $error_count += 1;
            }
        }

        echo "\n";
        echo "Created: ". $created_count ."\n";
        // echo "Updated: ". $updated_count ."\n";
        echo "Skipped: ". $skipped_count ."\n";
        echo "Errors: ". $error_count ."\n";
    }
}
