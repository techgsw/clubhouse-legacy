<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertSalesVaultQuestionNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('email')->Insert(
            [
                'code' => "sales_vault_question",
                'name' => 'Sales Vault Question Notifications',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('email')->where('code', '=', 'sales_vault_question')->delete();
    }
}
