<?php

use App\Role;
use App\RoleUser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClubhouseCollaboratorRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $clubhouse_collaborator = new Role();
        $clubhouse_collaborator->code = 'clubhouse_collaborator';
        $clubhouse_collaborator->description = 'Student ambassadors using theClubhouse. Not present in the membership report. This still requires the "clubhouse" role.';
        $clubhouse_collaborator->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RoleUser::where('role_code', 'clubhouse_collaborator')->delete();
        Role::where('code', 'clubhouse_collaborator')->delete();
    }
}
