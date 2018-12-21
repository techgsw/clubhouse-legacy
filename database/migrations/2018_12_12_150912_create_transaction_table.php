<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Providers\StripeServiceProvider;
use App\User;
use App\Product;
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

        Schema::create('payment_type', function (Blueprint $table) {
            $table->string('code')->unique();
            $table->string('description');
        });
        // Insert Product Types
        DB::table('payment_type')->insert(
            array(
                'code' => 'single',
                'description' => 'Product is purchased one time.'
            )
        );
        DB::table('payment_type')->insert(
            array(
                'code' => 'recurring',
                'description' => 'Product is a recurring subscription.'
            )
        );

        // Update product table to use payment_type
        Schema::table('product', function (Blueprint $table) {
            $table->string('payment_type_code')->default('single');
            $table->foreign('payment_type_code')->references('code')->on('payment_type');
        });

        $clubhouse = Product::where('name','Clubhouse Pro Membership')->first();
        $clubhouse->payment_type_code = 'recurring';
        $clubhouse->save();

        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->string('stripe_charge_id')->nullable()->default(NULL);
            $table->string('stripe_order_id')->nullable()->default(NULL);
            $table->string('stripe_subscription_id')->nullable()->default(NULL);
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
                try {
                    $transactions = StripeServiceProvider::getUserTransactions($user);
                } catch (\Exception $e) {
                   Log::error($e); 
                }
                $orders = (isset($transactions['orders']) ? $transactions['orders'] : array());
                $subscriptions = (isset($transactions['subscription']) ? $transactions['subscription'] : array());
                foreach ($orders as $order) {
                    $order = $order["order"];
                    $total_price = $order['total_amount'] / 100;
                    $create_date = $order['created'];      // UNIX TIMESTAMP 
                    $item = $order['items'][0];            // At time of this migration only 1 item per order was allowed
                    $sku_id = $item->parent;

                    // Create transaction 
                    $transaction = new Transaction();
                    $transaction->user_id = $user->id;
                    $transaction->amount = $total_price;
                    $transaction->created_at = (new DateTime())->setTimestamp($create_date);

                    if (isset($order['charge_object'])) {
                        $charge_object = $order['charge_object'];
                        $transaction->stripe_charge_id = $charge_object->id;
                        $transaction->stripe_order_id = $charge_object->order;
                    }
                    $transaction->save();

                    // Create transaction_product_option
                    $product_option = ProductOption::where('stripe_sku_id', $sku_id)->first();
                    $transaction_product_option = new TransactionProductOption();
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
                    $amount = $invoice_line_item->plan->amount / 100;
                    $create_date = $sub->date;
                    
                    // Create transaction 
                    $transaction = new Transaction();
                    $transaction->user_id = $user->id;
                    $transaction->amount = $amount;
                    $transaction->created_at = (new DateTime())->setTimestamp($create_date);
                    $transaction->stripe_subscription_id = $sub->subscription;

                    if (!is_null($sub->charge)) {
                        $transaction->stripe_charge_id = $sub->charge->id;
                    }

                    $transaction->save();

                    // Create transaction_product_option
                    $product_option = ProductOption::where('stripe_plan_id', $plan_id)->first();
                    $transaction_product_option = new TransactionProductOption();
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
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign(['payment_type_code']);
            $table->dropColumn('payment_type_code');
        });

        Schema::dropIfExists('payment_type');
        Schema::dropIfExists('transaction_product_option');
        Schema::dropIfExists('transaction');
    }
}
