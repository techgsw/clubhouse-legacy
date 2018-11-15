<?php

namespace App\Mail;

use App\User;
use App\ProductOption;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $product_option;
    public $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, ProductOption $product_option, $amount)
    {
        $this->user = $user;
        $this->product_option = $product_option;
        $this->amount = ($amount > 0 ? $amount / 100 : 0);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')
            ->subject('Payment Receipt - theClubhouse')
            ->markdown('emails.checkout.paid');
    }
}
