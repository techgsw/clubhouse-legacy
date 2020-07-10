<?php

use App\ProductOption;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HighestOptionRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function(Blueprint $table) {
            $table->string('highest_option_role')->nullable();
        });

        $clubhouse_products = ProductOption::whereHas('roles', function ($query) {
            $query->where('role_code', 'clubhouse');
        })->groupBy('product_id')->pluck('product_id')->toArray();

        $user_products = ProductOption::whereDoesntHave('roles', function ($query) {
            $query->where('role_code', 'clubhouse');
        })->whereHas('roles', function ($query) {
            $query->where('role_code', 'user');
        })->groupBy('product_id')->pluck('product_id')->toArray();

        $guest_products = ProductOption::doesntHave('roles')->groupBy('product_id')->pluck('product_id')->toArray();

        DB::table('product')->whereIn('id', $clubhouse_products)->update([
            'highest_option_role' => 'clubhouse'
        ]);
        DB::table('product')->whereIn('id', $user_products)->update([
            'highest_option_role' => 'user'
        ]);
        DB::table('product')->whereIn('id', $guest_products)->update([
            'highest_option_role' => 'guest'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function(Blueprint $table) {
            $table->dropColumn('highest_option_role');
        });
    }
}
