<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmailUserRemoveDeprecatedUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $emailType = \App\Email::all();

        $emailType->each(function ($email) {
            $email->users()->each(function ($user) {
                if (strpos($user->email, 'sportsbusiness.solutions') !== false) {
                    DB::table('email_user')->delete($user->id);
                }
            });
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
