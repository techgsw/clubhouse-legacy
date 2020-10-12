<?php

use App\ProductOption;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransactionIsScheduled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction', function (Blueprint $table) {
            $table->boolean('scheduled_flag')->nullable();
        });

        ProductOption::whereHas('product.tags', function($query) {
            $query->where('name', 'Career Service');
        })->update([
            'description' => 
                \DB::raw("CONCAT(description, ' calendly-link=https://calendly.com/bob-hamer/career-service')")
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction', function (Blueprint $table) {
            $table->dropColumn('scheduled_flag');
        });
    }
}
