<?php

namespace App\Console\Commands;

use Mail;
use App\Contact;
use App\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class MapContactsToOrganizations extends Command
{
    protected $signature = 'contacts:assignOrganizations';
    protected $description = 'Assign contacts to existing organizations based on organization name.';
    protected $organization_map = array();
    protected $success_count = 0;
    protected $failure_count = 0;
    protected $null_count = 0;
    protected $unmapped_names = array();

    public function __construct()
    {
        parent::__construct();

        // Map all Organization names to IDs
        Organization::all()->each(function ($organization) {
            $name = trim(strtolower($organization->name));
            $this->organization_map[$name] = $organization->id;
        });

        // Add exceptions, etc. to avoid dupes
        // Leagues
        $this->link("MLB", "Major League Baseball");
        $this->link("MLS", "Major League Soccer");
        $this->link("NBA", "National Basketball Association");
        $this->link("NFL", "National Football League");
        $this->link("NHL", "National Hockey League");
        $this->link("WNBA", "Women's National Basketball League");
        $this->link("NLL", "National Lacrosse League");
        $this->link("AAL", "American Arena League");
        $this->link("ALPB", "Atlantic League");
        $this->link("ECHL", "East Coast Hockey League");
        $this->link("USL", "United Soccer League");
        $this->link("FL", "Frontier League");
        $this->link("AHL", "AHL");
        $this->link("NASCAR", "NASCAR");
        // Other
        $this->link('Brooklyn Nets', 'Brooklyn Sports & Entertainment');
        $this->link('Cincinatti Bengals', 'Cincinnati Bengals');
        $this->link('Edmonton Oilers', 'Oilers Entertainment Group');
        $this->link('FC Dallas (internship)', 'FC Dallas');
        $this->link('Florida Panthers and Miami Dolphins', 'Florida Panthers');
        $this->link('International Speedway Corp.', 'International Speedway Corporation');
        $this->link('International Speedway Corporation - kansas speedway', 'International Speedway Corporation');
        $this->link("LA Rams", "Los Angeles Rams");
        $this->link("Oakland A's", "Oakland Athletics");
        $this->link("One World Observatory", "Legends Global Sales");
        $this->link("Suns", "Phoenix Suns");
        $this->link("Tampa Bay Lightning", "Tampa Bay Sports & Entertainment");
        $this->link("The Cleveland Cavaliers", "Cleveland Cavaliers");
        $this->link("The Washington Wizards", "Wizards District Gaming");
    }

    protected function link($name, $organization_name)
    {
        $name = trim(strtolower($name));
        $this->organization_map[$name] = $this->mapToOrganization($organization_name);
    }

    protected function mapToOrganization($name)
    {
        $name = trim(strtolower($name));

        if (!array_key_exists($name, $this->organization_map)) {
            return null;
        }

        return $this->organization_map[$name];
    }

    public function handle()
    {
        echo "Mapping contacts to organizations...";
        echo "\n-----------------------";

        Contact::whereNotIn('id', DB::table('contact_organization')->pluck('contact_id'))->each(function ($contact) {
            if (empty($contact->organization)) {
                $this->null_count++;
                return;
            }

            $name = trim(strtolower($contact->organization));
            if (in_array($name, ['no','none','na','n/a','unemployed'])) {
                $this->null_count++;
                return;
            }

            $organization_id = $this->mapToOrganization($name);
            if (empty($organization_id)) {
                echo "\n{$contact->organization}";
                $this->failure_count++;
                return;
            }

            $contact->organizations()->attach($organization_id);
            $this->success_count++;
        });

        echo "\n-----------------------";
        echo "\nSuccess: {$this->success_count}";
        echo "\nFailure: {$this->failure_count}";
        echo "\nN/A:     {$this->null_count}";
        echo "\n";
    }
}
