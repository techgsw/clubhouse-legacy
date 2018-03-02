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
        echo "Uploading contacts from " . $this->argument('filepath') . "...\n";

        $handle = fopen($this->argument('filepath'), "r");
        $header = true;
        $created_count = 0;
        $updated_count = 0;
        $error_count = 0;
        $line_number = 0;

        while (($row = fgetcsv($handle, ",")) !== false) {
            if ($header) {
                $header = false;
                continue;
            }

            $row_size = count($row);
            $email = $row[7];

            $contact = Contact::where('email', '=', $email)->get();
            if (count($contact) > 0) {
                echo "Already have " . $email . "\n";
                //TODO: update current contact with info.
                // Or don't? Which fields do we want to overwrite of existing data?
                $updated_count += 1;
                continue;
            }

            $sbs_reps = array();
            if ($multi_rep = explode('/', $row[0])) {
                foreach ($multi_rep as $rep) {
                    $sbs_reps[] = $rep;
                }
            }
            $sbs_reps[] = (($row[1] !== "") ? $row[1] : null);
            $sbs_reps[] = (($row[2] !== "") ? $row[2] : null);

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

            $contact = DB::transaction(function() use($args, $line_number) {
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

                // TODO: Uncomment adding address and contact_address when migration is in for these tables.
                //$address = Address::create([
                //    'line1' => $args['line_one'],
                //    'line2' => null,
                //    'city' => $args['city'],
                //    'state' => $args['state'],
                //    'postal_code' => $args['postal_code'],
                //    'country' => $args['country']
                //]);

                //$address_contact = AddressContact::create([
                //    'address_id' => $address->id,
                //    'contact_id' => $contact->id
                //]);

                foreach ($args['sbs_reps'] as $rep) {
                    if (is_null($rep)) {
                        continue;
                    }
                    $user = User::where('first_name', 'like', $rep)
                        ->where('email', 'like', '%sportsbusiness.solutions')->first();
                    if (count($user) > 0) {
                        $existing_relationship = ContactRelationship::where('contact_id', '=', $contact->id)
                            ->where('user_id', '=', $user->id)->get();
                        if (count($existing_relationship) < 1) {
                            $contact_relationship = ContactRelationship::create([
                                'contact_id' => $contact->id,
                                'user_id' => $user->id
                            ]);
                        }
                    } else {
                        echo "Invalid Sbs Rep " . $rep ." on line " . $line_number . "\n";
                    }
                }

                return $contact;
            });

            if (!is_null($contact)) {
                $created_count += 1;
            } else {
                echo "Error creating " . $args['first_name'] ." on line " . $line_number . "\n";
                $error_count += 1;
            }

            $line_number = $created_count + $updated_count + $error_count + 2;
        }

        echo "Done! \n";
        echo "Created: ". $created_count ."\n";
        echo "Updated: ". $updated_count ."\n";
        echo "Errors: ". $error_count ."\n";
    }
}
