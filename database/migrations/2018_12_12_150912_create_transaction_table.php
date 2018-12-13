<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Providers\StripeServiceProvider;
use App\User;
use App\ProductOption;
use App\Transaction;
use App\TransactionProductOption;

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
                $orders = (isset($transactions['orders']) ? $transactions['orders'] : array());
                $subscriptions = (isset($transactions['subscription']) ? $transactions['subscription'] : array());
                foreach ($orders as $order) {
                    $order = $order["order"];
                    $total_price = $order['total_amount'];
                    $create_date = $order['created'];      // UNIX TIMESTAMP 
                    $item = $order['items'][0];            // At time of this migration only 1 item per order was allowed
                    $sku_id = $item->parent;
                    $quantity = $item->quantity;

                    // Create transaction 
                    $transaction = new Transaction;
                    $transaction->user_id = $user->id;
                    $transaction->price = $total_price;
                    $transaction->created_at = (new DateTime())->setTimestamp($create_date);
                    $transaction->save();

                    // Create transaction_product_option
                    $product_option = ProductOption::where('stripe_sku_id', $sku_id)->first();
                    $transaction_product_option = new TransactionProductOption;
                    $transaction_product_option->transaction_id = $transaction->id;
                    $transaction_product_option->product_option_id = $product_option->id;
                    $transaction_product_option->save();
                    //echo "Order Item: ". $item->description. " ";
                    //echo "Order Item Count: ". count($order['items']). "\n";

                }
                foreach ($subscriptions as $sub) {
                    $sub = $sub['invoice'];
                    $invoice_line_item = $sub->lines->data[0];
                    // TIMESTAMP
                    $plan_id = $invoice_line_item->plan->id;
                    $amount = $invoice_line_item->plan->amount;
                    $create_date = $sub->date;
                    
                    // Create transaction 
                    $transaction = new Transaction;
                    $transaction->user_id = $user->id;
                    $transaction->price = $amount;
                    $transaction->created_at = (new DateTime())->setTimestamp($create_date);
                    $transaction->save();

                    // Create transaction_product_option
                    $product_option = ProductOption::where('stripe_plan_id', $plan_id)->first();
                    $transaction_product_option = new TransactionProductOption;
                    $transaction_product_option->transaction_id = $transaction->id;
                    $transaction_product_option->product_option_id = $product_option->id;
                    $transaction_product_option->save();
                }
            }
        );
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
