<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertContactResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create contact relationship
        DB::table('resource')->insert(
            array(
                'code' => 'contact_relationship_create',
                'description' => "Can create a contact relationship."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_relationship_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_relationship_create',
                'role_code' => 'superuser'
            )
        );

        // Delete contact relationship
        DB::table('resource')->insert(
            array(
                'code' => 'contact_relationship_delete',
                'description' => "Can delete a contact relationship."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_relationship_delete',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_relationship_delete',
                'role_code' => 'superuser'
            )
        );

        DB::table('resource_role')->where('resource_code', 'profile_note_create')->delete();
        DB::table('resource_role')->where('resource_code', 'profile_note_show')->delete();
        DB::table('resource')->where('code', 'profile_note_create')->delete();
        DB::table('resource')->where('code', 'profile_note_show')->delete();

        // Create contact note
        DB::table('resource')->insert(
            array(
                'code' => 'contact_note_create',
                'description' => "Can create a contact note."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_note_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_note_create',
                'role_code' => 'superuser'
            )
        );

        // View contact note
        DB::table('resource')->insert(
            array(
                'code' => 'contact_note_show',
                'description' => "Can view a contact note."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_note_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'contact_note_show',
                'role_code' => 'superuser'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('resource_role')->where('resource_code', 'contact_relationship_create')->delete();
        DB::table('resource_role')->where('resource_code', 'contact_relationship_delete')->delete();
        DB::table('resource')->where('code', 'contact_relationship_create')->delete();
        DB::table('resource')->where('code', 'contact_relationship_delete')->delete();
        DB::table('resource_role')->where('resource_code', 'contact_note_create')->delete();
        DB::table('resource_role')->where('resource_code', 'contact_note_show')->delete();
        DB::table('resource')->where('code', 'contact_note_create')->delete();
        DB::table('resource')->where('code', 'contact_note_show')->delete();

        // Restore profile note ACL
        DB::table('resource')->insert(
            array(
                'code' => 'profile_note_create',
                'description' => "Can create a profile note."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_note_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_note_create',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'profile_note_show',
                'description' => "Can view a profile note."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_note_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_note_show',
                'role_code' => 'superuser'
            )
        );
    }
}
