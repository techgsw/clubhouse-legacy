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

        foreach ($users as $user) {
            if (!$user->roles->contains('job_administrator')){
                DB::table('role_user')->insert(
                    array (
                        'user_id' => $user->id,
                        'role_code' => 'job_administrator'
                    )
                );
            }
        }
        DB::table('role')->insert(
            array (
                'code' => 'Free',
                'description' => 'Free for 30 days, or until filled'
            )
        );
        DB::table('role')->insert(
            array (
                'code' => 'Tier 1',
                'description' => 'Tier 1 is currently priced at $250 for 60 days, or until filled.'
            )
        );
        DB::table('role')->insert(
            array (
                'code' => 'Tier 2',
                'description' => 'Tier 2 is currently priced at $500 for 90 days, or until filled.'
            )
        );
        
        
        Schema::table('job', function (Blueprint $table) {
            $table->date('ending_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
