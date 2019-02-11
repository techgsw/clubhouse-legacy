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
        
        // TODO add try catch
        $handle = fopen($this->argument('filepath'), "r");
        
        $header = false;
        $created_count = 0;
        $updated_count = 0;
        $skipped_count = 0;
        $duplicate_count = 0;
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
            
            if (!$header) {
                for ($i=0; $i < count($expected_header); $i++) {
                    if (count($row) >= count($expected_header) && preg_replace("/\s/", "_", strtoLower($row[$i])) == $expected_header[$i]) {
                        $header = true;
                    }
                    else { 
                        $header = false;
                    }
                }

                if ($header) {
                    continue;
                }
            }

            $row_size = count($row);
            if (count($row) < 8) {
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

            $contact = Contact::with('address')->where('first_name', '=', $record['first_name'])
                                               ->Where('last_name', '=', $record['last_name'])
                                               ->get();
            
            if (count($contact) > 1) {
                echo  "Has more than one record. Unable to update " . $record['first_name'] . ' ' . $record['last_name'] . "\n";

                $duplicate_count += 1;
                continue;
            }

            // TODO dont kick out on no org match. Just dont create the org, still update address if applicable.
            $org = Organization::where('name', '=', $record['org'])->first();

            if (is_null($org) && count($contact) > 0) {
            
                echo "Organization does not exist, but contact does - Attempting to update contact information for " . $contact[0]->first_name . " " . $contact[0]->last_name . ". \n"; 

                $address = $contact[0]->address[0];
                
                $address->line1 = $record['street'];
                $address->city = $record['city'];
                $address->state = $record['state'];
                $address->postal_code = $record['zip'];
                $address->country = $record['country'];
                $address->save();

                $updated_count += 1;
                
                continue;
            }
            if (!is_null($org)) {
                if (count($contact) == 1) {
                    echo "Found contact match, attempting to update " . $contact[0]->first_name . " " . $contact[0]->last_name . "\n";
                    
                    // Update
                    $contact = DB::transaction(function() use($contact, $record, $line_number, $sbs_name_to_user, $row_num, &$updated_count, &$error_count, $org) {

                        $contact_organization = ContactOrganization::where('contact_id' ,'=', $contact[0]->id)->get();
                        
                        $contact_organization_id = ContactOrganization::where('organization_id' ,'=', $org->id)->get();
                        
                        if (count($contact_organization) == 0 && !is_null($org)) {
                            echo "Creating organization link" . "\n";
                            
                            $contact_organization_id = ContactOrganization::create([
                                'contact_id' => $contact[0]->id,
                                'organization_id' => $org->id,
                            ]);
                            
                        }
                        $contact_organization = ContactOrganization::where('contact_id' ,'=', $contact[0]->id)->get();
                        // TODO dont update contact_org info if contact_org > 1
                        if (count($contact_organization) > 1) {
                            echo "Contact match had more than one organization association.";
                            $address = $contact[0]->address[0];
                            $address->line1 = $record['street'];
                            $address->city = $record['city'];
                            $address->state = $record['state'];
                            $address->postal_code = $record['zip'];
                            $address->country = $record['country'];
                            $address->save();

                            $updated_count += 1;

                            return $contact;
                        }
                        // TODO this should be == 1
                        elseif (count($contact_organization) == 1) {

                            if ($org->id != $contact_organization[0]->organization_id) {
                                echo "Update Organization ID" . "\n";
                                $contact_organization[0]->organization_id = $org->id;
                            }

                            $contact[0]->organization = $org->name;
                            $address = $contact[0]->address[0];

                            $address->line1 = $record['street'];
                            $address->city = $record['city'];
                            $address->state = $record['state'];
                            $address->postal_code = $record['zip'];
                            $address->country = $record['country'];

                            $contact[0]->save();
                            $contact_organization[0]->save();                            
                            $address->save();
                            $org->save();

                            $updated_count += 1;

                            return $contact;
                        }
                        else {
                            echo "Invalid organization - " . $contact[0]->first_name . " " . $contact[0]->last_name . " on organization " . $record["org"] .  "\n";
                            $error_count += 1;

                            return $contact;
                        }
                    });
                    
                }

                if (count($contact) < 1) {
                    // Insert
                    echo 'Creating a new contact ' . $record['first_name'] . " " . $record['last_name'] . "\n";
                    $contact = DB::transaction(function() use($contact, $record, $line_number, $sbs_name_to_user, $row_num, &$skipped_count, &$error_count, &$created_count, $org) {
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

                        $contact_organization = ContactOrganization::create([
                            'contact_id' => $contact->id,
                            'organization_id' => $org->id,
                        ]);
                        
                        $created_count += 1;
                        return $contact;
                    });
                }
            }
            else {

                echo "Organization and contact do not exist, attempting to create a contact.\n"; 
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

                $created_count += 1;
            }
        }

        echo "\n";
        echo "Created: ". $created_count ."\n";
        echo "Updated: ". $updated_count ."\n";
        echo "Duplicates: ". $duplicate_count ."\n";
        // echo "Skipped: ". $skipped_count ."\n";
        echo "Errors: ". $error_count ."\n";
    }
}
