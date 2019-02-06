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

class UpdateContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:contacts {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update contacts given CSV file.';

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

            //Expected org,first_name,last_name,street,city,state,zip,country

            $record = array(
                'org' => $row[0],
                'first_name' => $row[1],
                'last_name' => $row[2],
                'street' => $row[3],
                'city' => $row[4],
                'state' => $row[5],
                'zip' => $row[6],
                'country' => $row[7],
            ); 

            $contact = Contact::with('address')->where('first_name', '=', $record['first_name'])
                                               ->Where('last_name', '=', $record['last_name'])
                                               ->get();
                                            // ->toSql();

            if (count($contact) > 1) {
                echo $record['first_name'] . ' ' . $record['last_name'] . " has more than one record. Unable to update.\n";
                
                $skipped_count += 1;
                continue;
            }

            if (count($contact) == 1) {
                echo $contact[0]->address[0]->line1."\n";
                echo $record['street']."\n";

                // Update
                $contact = DB::transaction(function() use($contact, $record, $line_number, $sbs_name_to_user, $row_num) {
                    $contact->organization = $record['org'];

                    // Write query to grab record for contact_organization;

                    // Update or insert as required

                    $org = Organization::where('name', '=', $record['org'])->first();

                    $address = $contact[0]->address[0];

                    $address->line1 = $record['street'];
                    $address->city = $record['city'];
                    $address->state = $record['state'];
                    $address->postal_code = $record['zip'];
                    $address->country = $record['country'];

                    $address->save();
                });
                die();
            }
            
            if (count($contact) < 1) {
                // Insert
                $contact = DB::transaction(function() use($contact, $record, $line_number, $sbs_name_to_user, $row_num) {
                    $contact = Contact::create([
                        'first_name' => $args['first_name'],
                        'last_name' => $args['last_name'],
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

                    // Create record for contact_organization;
                    // Update or insert as required

                });
            }


            $contact = DB::transaction(function() use($args, $line_number, $sbs_name_to_user, $row_num) {
                
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
