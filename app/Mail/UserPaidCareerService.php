<?php

namespace App\Mail;

use App\User;
use App\ProductOption;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPaidCareerService extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $product_option;
    public $transaction_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, ProductOption $product_option, $transaction_id)
    {
        $this->user = $user;
        $this->product_option = $product_option;
        $this->transaction_id = $transaction_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')
            ->subject('Career Service '.(\Gate::allows('view-clubhouse') ? 'Signup' : 'Payment').' - theClubhouse')
            ->markdown('emails.checkout.paid-career-service');
    }
}
