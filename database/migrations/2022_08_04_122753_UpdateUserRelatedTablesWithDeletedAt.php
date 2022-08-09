<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserRelatedTablesWithDeletedAt extends Migration
{
    const TABLES = [
        'user',
        'contact',
        'profile',
        'post',
        'question',
        'answer',
        'job',
        'role_user',
        'inquiry',
        'address',
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        collect(self::TABLES)->each(function ($table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dateTime('deleted_at')->nullable()->default(NULL);
            });
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        collect(self::TABLES)->each(function ($table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        });
        Schema::enableForeignKeyConstraints();
    }
}
