<?php

namespace App\Console\Commands;

use Mail;
use App\Contact;
use App\ContactRelationship;
use App\Address;
use App\User;
use App\AddressContact;
use App\Organization;
use App\ContactOrganization;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class ReconcileContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reconcile:contacts {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the contacts given in the CSV file with the values in the DB.';

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
        echo "Reconciling contacts from " . $this->argument('filepath') . "...\n\n";
        
        try {          
            $handle = fopen($this->argument('filepath'), "r");
        } catch (Exception $e) {
            echo "Invalid file path please try ensure you are using the correct path.\n";
        }

        $header = false;
        // Change me if columns on the end are nullable
        $row_size_expected_count = 8;
        $error_count = 0;
        $skipped_count = 0;
        $duplicate_count = 0;

        while (($row = fgetcsv($handle, ",")) !== false) {

            $expected_header = array(
                0 => 'team_name',
                1 => 'first_name',
                2 => 'last_name',
                3 => 'mailing_street',
                4 => 'city',
                5 => 'state',
                6 => 'zip',
                7 => 'country',
            );

            $row_size = count($row);
            
            if (!$header) {
                if ($row_size >= count($expected_header)) {
                    for ($i=0; $i < count($expected_header); $i++) {
                        if (preg_replace("/\s/", "_", strtoLower($row[$i])) != $expected_header[$i]) {
                            echo "Invalid header row data, trying next row. \n";
                            $skipped_count += 1;
                            continue 1;
                        }
                    }
                } else {
                    echo "Invalid header row data, trying next row. \n";
                    $skipped_count += 1;
                    continue;
                }
                $header = true;
                continue;
            }
            
            // For any row where first name and last name are not populated in the csv cells.
            if ($row_size < $row_size_expected_count || empty($row[1]) || empty($row[2])) {
                echo "First name or last name fields are incomplete, skipping row/record. \n";
                $skipped_count += 1;
                continue;
            }

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

            // Getting all contacts with the associated first_name and last_name
            $contact_result = Contact::with('address')->where('first_name', '=', $record['first_name'])
                                               ->where('last_name', '=', $record['last_name'])
                                               ->get();
            // Returns an object
            $org = Organization::where('name', '=', $record['org'])->first();

            // After this point there can be either one or no matching contact in the $contact_result
            if (count($contact_result) == 0) { 
                echo "Something with wrong with the creation of " . $contact_result[0]->first_name . " " . $contact_result[0]->last_name . "\n";
                $error_count += 1;
                continue;
            } elseif ((count($contact_result) == 1)) {

                // We should only have one contact since we are creating none
                $contact = $contact_result[0];

                // Setting the address contact to object
                $address = $contact->address[0];

                // Gets the values back from the table linking address and contact
                $address_contact = AddressContact::where('contact_id', '=', $contact->id)->get();

                //Address is good so check it
                if (!is_null($address)) {
                    
                    if ($address->line1 != $record['street'] || $address->city != $record['city'] || $address->state != $record['state'] 
                        || $address->postal_code != $record['zip'] || $address->country != $record['country']) {

                        echo "Address did not match for " . $contact->first_name . " " . $contact->last_name . "\n";
                        $error_count += 1;
                        continue;
                    }

                    if ($address_contact[0]->contact_id != $contact->id || $address_contact[0]->address_id != $address->id) {

                        echo "AddressContact did not match for " . $contact->first_name . " " . $contact->last_name . "\n";
                        $error_count += 1;
                        continue;
                        
                    }

                } else {

                    echo "Created user address is null " . $contact->first_name . " " . $contact->last_name . "\n";
                    $error_count += 1;
                    continue;

                }

                // Finished checking address, now org
                if (!is_null($org)) {

                    // org not null so getting their organization contact
                    $contact_organization = ContactOrganization::where('contact_id' ,'=', $contact->id)->get();

                    if ($org->name != $contact->organization) {

                        echo "Contact organization did not match for " .  $contact->first_name . " " . $contact->last_name . "\n";
                        $error_count += 1;
                        continue;

                    }

                    if ($org->id != $contact_organization[0]->organization_id || $contact->id !=  $contact_organization[0]->contact_id) {

                        echo "Contact organization did not match for " . $contact->first_name . " " . $contact->last_name . "\n" ;
                        $error_count += 1;
                        continue;

                    }
                    
                } else {

                    echo "Created user organization is null " . $contact->first_name . " " . $contact->last_name . "\n";
                    // $error_count += 1;
                    continue;

                }
            
            // This would mean that we have greater than one contact returned from the DB
            }  else {
                echo  "Has more than one record. Unable to reconcile " . $record['first_name'] . ' ' . $record['last_name'] . "\n";

                $duplicate_count += 1;
                continue;
            }
        }

        echo "\n";
        echo "Errored: " . $error_count . "\n";
        echo "Duplicates: ". $duplicate_count . "\n";
        echo "Skipped: " . $skipped_count . "\n";
    }
}
