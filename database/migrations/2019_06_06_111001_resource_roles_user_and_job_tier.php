<?php

use App\User;
use App\Job;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResourceRolesUserAndJobTier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('role')->insert(
            array (
                'code' => 'job_user',
                'description' => 'Free version of the job board.'
            )
        );
        DB::table('role')->insert(
            array (
                'code' => 'job_user_featured',
                'description' => 'Paid version of the job board, second tier access.'
            )
        );
        DB::table('role')->insert(
            array (
                'code' => 'job_user_platinum',
                'description' => 'Paid version of the job board, third tier access.'
            )
        );

        DB::table('resource')->insert(
            array (
                'code' => 'job_close_user',
                'description' => 'Can close their own jobs.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_create_user',
                'description' => 'Can create their own jobs.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_delete_user',
                'description' => 'Can delete their own jobs.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_edit_user',
                'description' => 'Can edit their own jobs.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_index_user',
                'description' => 'Can view their own job dasboard.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_show_user',
                'description' => 'Can view their individual jobs.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_featured_user',
                'description' => 'Can access featured job features.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_platinum_user',
                'description' => 'Can access platinum job features.'
            )
        );

        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_close_user',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_create_user',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_delete_user',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_edit_user',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_index_user',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_show_user',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_create',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_edit',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_featured_user',
                'role_code' => 'job_user_featured'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_platinum_user',
                'role_code' => 'job_user_platinum'
            )
        );
        
        $users = User::all();
        foreach ($users as $user) {
            if (!$user->roles->contains('job_user')){
                DB::table('role_user')->insert(
                    array (
                        'user_id' => $user->id,
                        'role_code' => 'job_user'
                    )
                );
            }
        }
        

        Schema::table('transaction', function (Blueprint $table) {
            $table->integer('job_id')->unsigned()->nullable()->default(NULL)->after('stripe_subscription_id');
        });

        Schema::create('job_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->timestamps();
        });

        DB::table('job_type')->insert(
            array(
                'name' => 'SBS Default',
                'code' => 'sbs-default'
            )
        );

        DB::table('job_type')->insert(
            array(
                'name' => 'User Free',
                'code' => 'user-free'
            )
        );

        DB::table('job_type')->insert(
            array(
                'name' => 'User Featured',
                'code' => 'user-featured'
            )
        );

        DB::table('job_type')->insert(
            array(
                'name' => 'User Platinum',
                'code' => 'user-platinum'
            )
        );

        Schema::table('job', function (Blueprint $table) {
            $table->integer('job_type_id')->unsigned()->default(1)->after('job_type');
            $table->foreign('job_type_id')->references('id')->on('job_type');
        });

        Schema::table('organization', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->after('id');
            $table->boolean('approved')->default(false)->after('name');
        });

        DB::update("UPDATE `organization` SET `user_id` = 1 WHERE `id` > 0");

        Schema::table('organization', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user');
        });

        DB::update("UPDATE `organization` SET `approved` = true WHERE `id` > 0");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
