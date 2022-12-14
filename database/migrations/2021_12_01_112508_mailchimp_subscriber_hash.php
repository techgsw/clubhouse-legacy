<?php

use App\Providers\MailchimpServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailchimpSubscriberHash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('mailchimp_subscriber_hash')->nullable()->default(NULL);
        });
        MailchimpServiceProvider::refreshMailchimpSubscriberHashes();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('mailchimp_subscriber_hash');
        });
    }
}
