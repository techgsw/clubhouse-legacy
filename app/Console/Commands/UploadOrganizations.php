<?php

namespace App\Console\Commands;

use Mail;
use App\Address;
use App\League;
use App\Organization;
use App\OrganizationType;
use App\Providers\OrganizationServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class UploadOrganizations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:organizations {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload organizations given CSV file.';

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
        echo "Uploading organizations from ".$this->argument('filepath');
        echo "\n------------------------";

        $handle = fopen($this->argument('filepath'), "r");
        $header = true;
        $created_count = 0;
        $updated_count = 0;
        $skipped_count = 0;
        $error_count = 0;
        $line_number = 0;

        $row_num = 1;
        while (($row = fgetcsv($handle, ",")) !== false) {
            $row_num++;

            if ($header) {
                $header = false;
                continue;
            }

            $row_size = count($row);
            $organization_name = $row[3];
            $is_league = !empty($row[4]);

            $league_ot = OrganizationType::where('code', 'league')->first();

            if (!$organization_name || strlen($organization_name) == 0) {
                echo "\nOrganization name required: missing on row {$row_num}";
                continue;
            }

            $organization = Organization::where('name', '=', $organization_name)->first();
            if (!empty($organization)) {
                echo "\n{$organization_name} already exists";
                $skipped_count += 1;
                continue;
            }

            $league = League::where('abbreviation', '=', $organization_name)->first();
            if (!empty($league)) {
                echo "\n{$organization_name} already exists";
                $skipped_count += 1;
                continue;
            }

            $parent = Organization::where('name', 'LIKE', $organization_name." - %")->first();
            if (!empty($parent)) {
                echo "\n{$organization_name} parent: {$parent->name}";
            }

            $args = array(
                'line_one'     => (($row[10] !== "") ? $row[10] : null),
                'city'         => (($row[11] !== "") ? $row[11] : null),
                'state'        => (($row[12] !== "") ? $row[12] : null),
                'postal_code'  => (($row[13] !== "") ? $row[13] : null),
                'country'      => (($row[14] !== "") ? $row[14] : null)
            );

            $organization = DB::transaction(function() use(
                $organization_name,
                $parent,
                $args,
                $line_number,
                $is_league,
                $league_ot
            ) {
                $organization = new Organization([
                    'name' => $organization_name
                ]);
                $organization->parent_organization_id = empty($parent) ? null : $parent->id;
                if ($is_league) {
                    $organization->organization_type_id = $league_ot->id;
                }
                $organization->save();

                if ($is_league) {
                    $league = new League([
                        'abbreviation' => $organization_name
                    ]);
                    $league->organization_id = $organization->id;
                    $league->save();
                }

                $address = Address::create([
                   'line1' => $args['line_one'],
                   'line2' => null,
                   'city' => $args['city'],
                   'state' => $args['state'],
                   'postal_code' => $args['postal_code'],
                   'country' => $args['country']
                ]);

                $organization->addresses()->attach($address->id);

                return $organization;
            });

            if (!is_null($organization)) {
                $created_count += 1;
            } else {
                echo "Error creating organization on row ".$row_num."\n";
                $error_count += 1;
            }
        }

        echo "\n------------------------";
        echo "\nCreated:    {$created_count}";
        echo "\nDuplicates: {$skipped_count}";
        echo "\nErrors:     {$error_count}";
        echo "\n";
    }
}
