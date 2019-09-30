<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrganizationEditUserResource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('resource')->insert([
            'code' => 'organization_edit_user',
            'description' => 'Can edit their own organization.'
        ]);

        DB::table('resource_role')
            ->where('role_code', 'job_user')
            ->where('resource_code', 'organization_edit')
            ->update(['resource_code' => 'organization_edit_user']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('resource_role')
            ->where('role_code', 'job_user')
            ->where('resource_code', 'organization_edit_user')
            ->update(['resource_code' => 'organization_edit']);

        DB::delete('delete from resource where code= "organization_edit_user"');
    }
}
