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
        $row_num = 1;

        $sbs_name_to_user = [
            'bob' => 1,
            'jason' => 13,
            'mike' => 7,
            'josh' => 1952
        ];

        while (($row = fgetcsv($handle, ",")) !== false) {
	    
	    $row_num++;
            if($row[0] == "Sheet1: Table 1" || $row[0] == null){
                continue;
            }

            if ($header) {
                $header = false;
                continue;
            }

            $row_size = count($row);

            // Deprecated - Austin 2-6-19
            // Use - Searching by email based on a given row
            // $email = $row[7];

            // For searching by first and last name being that we have no emails
            $firstName = $row[1];
            $lastName = $row[2];

            // Deprecated - Austin 2-6-19
            // if (!$email || strlen($email) == 0) {
            //     echo "Email required. Missing on row ".$row_num.".\n";
            //     continue;
            // }
            
            //update records if they do exist
            
            //if duplicate dont do anything
            $contact = Contact::with('address')->where('first_name', '=', $firstName)
                                               ->Where('last_name', '=', $lastName)
                                               ->get();
                                            // ->toSql();
            // You could use this to get the Contact firstName if it had existed
            // $firstNameExists = Contact::where('first_name', '=', $firstName)->get();
            // $lastNameExists = Contact::where('last_name', '=', $lastName)->get();

            //update the contact address correcrtly
            //google join for DB
            //"Laravel eloquent relationships
            if (count($contact) > 0) {
                echo $firstName . ' ' . $lastName . " already exists.\n";
                // TODO Update?
                
                // dd($contact[0]);
                // dd($contact[0]->address);
                //Make sure count == 1 on contact else it will have a duplicate
                //contact[0] will get the first item in the array, then point to the property address
                dd($contact[0]->address);

                $skipped_count += 1;
                continue;
            }
            if(count($contact) > 1){
                echo "Potential duplicate found - " . $firstName . " " . $lastName;
            }
            // dd($contact);
            $sbs_reps = array();
            if ($multi_rep = explode('/', $row[0])) {
                foreach ($multi_rep as $rep) {
                    $sbs_reps[] = strtolower($rep);
                }
            }
            $sbs_reps[] = (($row[1] !== "") ? strtolower($row[1]) : null);
            $sbs_reps[] = (($row[2] !== "") ? strtolower($row[2]) : null);

            $args = array(
                'organization' => (($row[0] !== "") ? $row[0] : null),
                'first_name'   => (($row[1] !== "") ? $row[1] : null),
                'last_name'    => (($row[2] !== "") ? $row[2] : null),
                'title'        => (($row[8] !== "") ? $row[8] : null),
                'email'        => (($row[9] !== "") ? $row[9] : null),
                'phone'        => (($row[10] !== "") ? $row[10] : null),
                'line_one'     => (($row[9] !== "") ? $row[9] : null),
                'city'         => (($row[4] !== "") ? $row[4] : null),
                'state'        => (($row[5] !== "") ? $row[5] : null),
                'postal_code'  => (($row[6] !== "") ? $row[6] : null),
                'country'      => (($row[7] !== "") ? $row[7] : null),
                'sbs_reps'     => $sbs_reps
            );
            // dd($args);

            $contact = DB::transaction(function() use($args, $line_number, $sbs_name_to_user, $row_num) {
                $contact = Contact::create([
                    'first_name' => $args['first_name'],
                    'last_name' => $args['last_name'],
                    // 'email' => $args['email'],
                    'email' => null,
                    'phone' => $args['phone'],
                    'title' => $args['title'],
                    'organization' => $args['organization'],
                    'job_seeking_status' => null,
                    'job_seeking_type' => null,
                ]);
                // dd($contact);
                $address = Address::create([
                   'line1' => $args['line_one'],
                   'line2' => null,
                   'city' => $args['city'],
                   'state' => $args['state'],
                   'postal_code' => $args['postal_code'],
                   'country' => $args['country']
                ]);
                // dd($contact, $address);
                $address_contact = AddressContact::create([
                   'address_id' => $address->id,
                   'contact_id' => $contact->id
                ]);
                // $existing = ContactRelationship::where('contact_id', '=', $contact->id)
                //                                 ->where('user_id', '=', $sbs_name_to_user[0])
                //                                 ->get();
                // // dd($existing[0]);
                // if (count($existing) < 1) {
                //     $contact_relationship = ContactRelationship::create([
                //         'contact_id' => $contact->id,
                //         'user_id' => $user_id
                //     ]);
                // }

                // foreach ($args['sbs_reps'] as $name) {
                //     if (is_null($name)) {
                //         continue;
                //     }
                //     if (array_key_exists($name, $sbs_name_to_user)) {
                //         $user_id = $sbs_name_to_user[$name];
                //         $existing = ContactRelationship::where('contact_id', '=', $contact->id)
                //             ->where('user_id', '=', $user_id)->get();
                //         if (count($existing) < 1) {
                //             $contact_relationship = ContactRelationship::create([
                //                 'contact_id' => $contact->id,
                //                 'user_id' => $user_id
                //             ]);
                //         }
                //     } else {
                //         // dd($row_num);
                //         echo "Here";
                //         echo "Invalid SBS Rep (".$name.") on row ".$row_num."\n";
                //     }
                // }

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
