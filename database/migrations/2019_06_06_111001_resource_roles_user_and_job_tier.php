<?php

use App\User;
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
        //
        $users = User::all();

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
        
        Schema::table('job', function (Blueprint $table) {
            $table->date('start_at')->nullable()->default(NULL);
            $table->date('end_at')->nullable()->default(NULL);
        });

        Schema::table('transaction', function (Blueprint $table) {
            $table->integer('job_id')->unsigned()->nullable()->default(NULL)->after('stripe_subscription_id');
        });
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
