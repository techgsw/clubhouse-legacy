<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Providers\StripeServiceProvider;
use App\User;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        CREATE TABLE `transaction` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `user_id` int(10) NOT NULL,
            `price` decimal(10,3) NOT NULL,
            `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `id_UNIQUE` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        */
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->decimal('price', 10, 2);
            $table->foreign('user_id')->references('id')->on('user');
            $table->timestamps();
        });

        Schema::create('transaction_product_option', function (Blueprint $table) {
            $table->integer('transaction_id')->unsigned();
            $table->integer('product_option_id')->unsigned();
            $table->foreign('transaction_id')->references('id')->on('transaction');
            $table->foreign('product_option_id')->references('id')->on('product_option');
        });

        User::whereNotNull('stripe_customer_id')->each(
            function ($user) {
                $transactions = StripeServiceProvider::getUserTransactions($user);
                $orders = $transactions['orders'];
                $subscriptions = $transactions['subscriptions'];
                foreach ($orders as $order) {
                    $total_price = $order['order']['total_amount'];
                    // TIMESTAMP
                    $create_date = $order['order']['created'];
                    $sku_id = $order['order']['parent'];
                    // TODO: Create transaction relationships
                }
                foreach ($subscriptions as $sub) {
                    $total_price = $sub['invoice']['amount_paid'];
                    // TIMESTAMP
                    $create_date = $sub['invoice']['date'];
                    $list_item = $sub['invoice']['lines'];
                    
                    foreach ($list_item->data as $invoice_item) {
                        $plan_id = $invoice_item->plan->id;
                    }
                    // TODO: Create transaction relationships
                }
            }
        );

        //User::whereIn('email', $registration_summary_emails)->each(
        //    function ($user) use ($registration_summary_email) {
        //        $user->emails()->attach($registration_summary_email);
        //    }
        //);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_product_option');
        Schema::dropIfExists('transaction');
    }
}
