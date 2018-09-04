<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStripeSkuId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_option', function (Blueprint $table) {
            $table->string('stripe_sku_id')->after('stripe_product_id')->nullable()->default(NULL);
            $table->renameColumn('stripe_product_id', 'strip_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_option', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_sku_id',
            ]);
            $table->renameColumn('strip_plan_id', 'stripe_product_id');
        });
    }
}
