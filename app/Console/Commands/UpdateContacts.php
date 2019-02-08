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
        
        $header = true;
        $created_count = 0;
        $updated_count = 0;
        $skipped_count = 0;
        $error_count = 0;
        $line_number = 0;
        $row_num = 1;
        // echo "Herfe";

        $sbs_name_to_user = [
            'bob' => 1,
            'jason' => 13,
            'mike' => 7,
            'josh' => 1952
        ];

        while (($row = fgetcsv($handle, ",")) !== false) {

            $row_num++;

            // TODO validate header first, continue only if valid
            //Expected org,first_name,last_name,street,city,state,zip,country

            // TODO get rid of hardcoded corner case
            if($row[0] == "Sheet1: Table 1" || $row[0] == null){
                continue;
            }

            if ($header) {
                $header = false;
                continue;
            }

            $row_size = count($row);

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

                $error_count += 1;
                continue;
            }

            // TODO dont kick out on no org match. Just dont create the org, still update address if applicable.
            $org = Organization::where('name', '=', $record['org'])->first();  
            if($org = null){
                // echo "Null org";
                continue;
            }

            if (count($contact) == 1) {
                // Update
                echo "Found contact match, attempting to update" . "\n";

                // Update
                $contact = DB::transaction(function() use($contact, $record, $line_number, $sbs_name_to_user, $row_num, &$updated_count, &$error_count) {
                    // Write query to grab record for contact_organization;
                    // Update or insert as required
                    $org = Organization::where('name', '=', $record['org'])->first();  
                    //grab org see if exists compare to current and if they match create new org and upadte record      
                    //if not do nothing

                    // TODO if ORG is null, dont worry about ORG
                    if ($org != null) {
                    }
                    
                    // $contact_organization = ContactOrganization::where('organization_id', '=', $contact_org_id)
                    //                                             ->where('contact_id', '=', $contact[0]->id)
                    //                                             ->get();
                    
                    //compare values if incorrect update the record
                    //update relationship and update the column on contact record

                    $contact_organization = ContactOrganization::where('contact_id' ,'=', $contact[0]->id)->get();
                    $contact_organization_id = ContactOrganization::where('organization_id' ,'=', $contact_org_id)->get();
                    
                    if (count($contact_organization) == 0 && !is_null($org)) {
                        // dd($contact_organization_id);
                        echo "Creating organization link" . "\n";
                        // echo "contact_id " . $contact[0]->id . " org-id " . $org->id . "\n";
                        $contact_organization_id = ContactOrganization::create([
                             'contact_id' => $contact[0]->id,
                             'organization_id' => $org->id,
                         ]);
                    }

                    // TODO dont update contact_org info if contact_org > 1

                    // TODO this should be == 1
                    if (count($contact_organization) > 0 && !is_null($org)) {

                        if ($contact_org_id != $contact_organization[0]->organization_id) {
                            echo "Update Organization ID" . "\n";
                            $contact_organization[0]->organization_id = $contact_org_id;
                        }
                        if($org != null){
                            $contact[0]->organization = $org->name;
                        }
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
                    else{
                        echo "Invalid organization - " . $contact[0]->first_name . " " . $contact[0]->last_name . " on organization " . $record["org"] .  "\n";
                        $error_count += 1;
                        return $contact;
                    }
                });
            }

            if (count($contact) < 1) {
                // Insert
                echo 'Creating a new contact ' . $record['first_name'] . " " . $record['last_name'] . "\n";
                $contact = DB::transaction(function() use($contact, $record, $line_number, $sbs_name_to_user, $row_num, &$skipped_count, &$error_count, &$created_count) {
                    $contact = Contact::create([
                        'first_name' => $record['first_name'],
                        'last_name' => $record['last_name'],
                        'phone' => null,//$record['phone'],
                        'title' => null,//$record['title'],
                        'organization' => $record['org'],
                        'job_seeking_status' => null,
                        'job_seeking_type' => null,
                    ]);

                    //check to see if the organization exists
                    // $contact_organization = ContactOrganization::where('contact_id' ,'=', $contact->id)->get();
                    $org = Organization::where('name', '=', $record['org'])->first(); 
                    
                    if($org != null){
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
     
                         // Create record for contact_organization;
                         // Update or insert as required
                         //lookup by title
                         //find match
                         //update or insert

                         $contact_organization = ContactOrganization::create([
                             'contact_id' => $contact->id,
                             'organization_id' => $org->id,
                         ]);
                        //  $created_count += 1;
                        //  return $created_count;
                        //update contact organization like before for the contact organization. Like before with the arizona diamondbacks on Michael.
                    }
                    
                    $created_count += 1;
                    return $contact;
                });
            }
        }

        echo "\n";
        echo "Created: ". $created_count ."\n";
        echo "Updated: ". $updated_count ."\n";
        // echo "Skipped: ". $skipped_count ."\n";
        echo "Errors: ". $error_count ."\n";
    }
}
