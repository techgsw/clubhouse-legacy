<?php

use App\Role;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeveloperRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('role')->insert(
            array(
                'code' => 'developer',
                'description' => "Developer"
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'image_admin',
                'description' => "Can access admin-only image functionality."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'image_admin',
                'role_code' => 'developer'
            )
        );

        $developer = new Role();
        $developer->code = 'developer';
        $developers = ['niko@whale.enterprises', 'sean@whale.enterprises', 'cameron@whale.enterprises'];
        User::whereIn('email', $developers)->each(function ($user) use ($developer) {
            $user->roles()->attach($developer);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('resource_role')->where('resource_code', 'image_admin')->delete();
        DB::table('role_user')->where('role_code', 'developer')->delete();
        DB::table('resource')->where('code', 'image_admin')->delete();
        DB::table('role')->where('code', 'developer')->delete();
    }
}
