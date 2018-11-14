<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripeIdToProductOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_option', function (Blueprint $table) {
            $table->integer('stripe_product_id')->unsigned()->after('quantity')->nullable()->default(NULL);
            $table->string('product_type')->after('quantity')->default('good');
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
                'stripe_product_id',
                'product_type',
            ]);
        });
    }
}
