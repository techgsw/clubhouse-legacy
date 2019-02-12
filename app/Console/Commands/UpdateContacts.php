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
        
        try{          
            $handle = fopen($this->argument('filepath'), "r");
        }
        catch (Exception $e){
            echo "Invalid file path please try ensure you are using the correct path.\n";
        }

        $header = false;
        // Change me if columns on the end are nullable
        $row_size_expected_count = 8;
        $created_count = 0;
        $updated_count = 0;
        $skipped_count = 0;
        $duplicate_count = 0;
        $row_num = 0;

        while (($row = fgetcsv($handle, ",")) !== false) {

            $row_num++;

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
                            echo "Invalid row data, moving on. \n";
                            $skipped_count += 1;
                            continue 1;
                        }
                    }
                } else {
                    echo "Invalid row data, moving on. \n";
                    $skipped_count += 1;
                    continue;
                }
                $header = true;
                continue;
            }
            
            // For any row where first name and last name are not populated in the csv cells.
            if ($row_size < $row_size_expected_count || empty($row[1]) || empty($row[2])) {
                echo "Incomplete row, moving on. \n";
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
            
            // After this point there can be either one or no matching contact in the $contact_result
            if (count($contact_result) > 1) {
                echo  "Has more than one record. Unable to update " . $record['first_name'] . ' ' . $record['last_name'] . "\n";

                $duplicate_count += 1;
                continue;
            }

            // Returns an object
            $org = Organization::where('name', '=', $record['org'])->first();

            // Creating a new contact
            if (count($contact_result) == 0) {
                
                $contact = DB::transaction(function() use($record, $row_num, &$skipped_count, &$error_count, &$created_count, $org) {
                    $contact = Contact::create([
                        'first_name' => $record['first_name'],
                        'last_name' => $record['last_name'],
                        'phone' => null,//$record['phone'],
                        'title' => null,//$record['title'],
                        'organization' => $record['org'],
                        'job_seeking_status' => null,
                        'job_seeking_type' => null,
                    ]);
                    
                    $address = Address::create([
                        'line1' => $record['street'],
                        'line2' => null,
                        'city' => $record['city'],
                        'state' => $record['state'],
                        'postal_code' => $record['zip'],
                        'country' => $record['country']
                    ]);
                    
                    $address_contact = AddressContact::create([
                        'address_id' => $address->id,
                        'contact_id' => $contact->id
                    ]);

                    // If org is null, we cannot create the link between contact and organization
                    if (is_null($org)) {

                        echo 'Created a new contact - ' . $record['first_name'] . " " . $record['last_name'] . " - invalid organization " . "\n";                        
                    
                    // Else, the org exists and we can create the link
                    } else {
                        
                        $contact_organization = ContactOrganization::create([
                            'contact_id' => $contact->id,
                            'organization_id' => $org->id,
                        ]);
                        echo 'Created a new contact - ' . $record['first_name'] . " " . $record['last_name'] . " - valid organization " . "\n";
                        
                    }                        

                    $created_count += 1;
                    return $contact;
                });
                continue;
            }

            // Only one contact exists at this point
            $contact = $contact_result[0];
            
            // We have a contact, but the org is null
            if (is_null($org)) {

                // Setting address to an object from the addresses array
                $address = $contact->address[0];

                $address->line1 = $record['street'];
                $address->city = $record['city'];
                $address->state = $record['state'];
                $address->postal_code = $record['zip'];
                $address->country = $record['country'];
                $address->save();

                $updated_count += 1;
                echo "Organization does not exist, but contact does - Updating contact information for " . $contact->first_name . " " . $contact->last_name . ". \n"; 
                
                continue;

            } else {

                // Update
                $contact = DB::transaction(function() use($contact, $record, $row_num, &$updated_count, &$error_count, $org) {

                    $contact_organization = ContactOrganization::where('contact_id' ,'=', $contact->id)->get();
                    
                    // If their org exists but isn't linked, link it
                    if (count($contact_organization) == 0) {
                        
                        $contact_organization = ContactOrganization::create([
                            'contact_id' => $contact->id,
                            'organization_id' => $org->id,
                        ]);

                        $tmp[] = $contact_organization;
                        $contact_organization = $tmp;
                    
                    } 
                    
                    // I do not believe that this is possibly due to the way the website is configured
                    // But this looks possible in the DB due to the contact_id and organization_id not being unique,
                    // But on the website you are only able to add one organization to the contact

                    //elseif (count($contact_organization) > 1) {
                        
                    //     $address = $contact->address[0];
                    //     $address->line1 = $record['street'];
                    //     $address->city = $record['city'];
                    //     $address->state = $record['state'];
                    //     $address->postal_code = $record['zip'];
                    //     $address->country = $record['country'];
                    //     $address->save();

                    //     echo "Contact match had more than one organization association. " . $contact->first_name . " " . $contact->last_name . "\n";
                    //     $updated_count += 1;
                        
                    //     return $contact;
                    // }

                    // Check to see if the contact has changed organizations
                    if ($org->id != $contact_organization[0]->organization_id) {
                        // echo "Update Organization ID" . "\n";
                        $contact_organization[0]->organization_id = $org->id;
                    }

                    $contact->organization = $org->name;
                    $address = $contact->address[0];

                    $address->line1 = $record['street'];
                    $address->city = $record['city'];
                    $address->state = $record['state'];
                    $address->postal_code = $record['zip'];
                    $address->country = $record['country'];

                    $contact_organization[0]->save(); 
                    $contact->save();           
                    $address->save();
                    $org->save();

                    $updated_count += 1;
                    echo "Contact match found, and updated " . $contact->first_name . " " . $contact->last_name . "\n";
                    return $contact;
                });
            } 
        }

        echo "\n";
        echo "Created: ". $created_count ."\n";
        echo "Updated: ". $updated_count ."\n";
        echo "Duplicates: ". $duplicate_count ."\n";
        echo "Skipped: " . $skipped_count . "\n";
    }
}
