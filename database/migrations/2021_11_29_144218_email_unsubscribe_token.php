<?php

use App\Profile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailUnsubscribeToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->string('email_unsubscribe_token')->nullable()->default(NULL);
        });

        foreach (Profile::all() as $profile) {
            $profile->generateEmailUnsubscribeToken();
            $profile->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn('email_unsubscribe_token');
        });
    }
}
