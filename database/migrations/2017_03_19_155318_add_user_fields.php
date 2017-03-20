<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
            $table->string('last_name');
            $table->string('organization')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->boolean('is_sales_professional')->default(false);
            $table->boolean('receives_newsletter')->default(false);
            $table->boolean('is_interested_in_jobs')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->renameColumn('first_name', 'name');
            $table->dropColumn([
                'last_name',
                'organization',
                'is_sales_professional',
                'receives_newsletter',
                'is_interested_in_jobs'
            ]);
        });
    }
}
