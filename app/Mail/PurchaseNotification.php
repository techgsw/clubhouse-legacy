<?php

namespace App\Mail;

use App\User;
use App\ProductOption;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PurchaseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $product_option;
    public $amount;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, ProductOption $product_option, $amount, $type = null)
    {
        $this->user = $user;
        $this->product_option = $product_option;
        $this->amount = ($amount > 0 ? $amount / 100 : 0);
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')
            ->subject('Purchase/RSVP Notification - theClubhouse')
            ->markdown('emails.internal.purchase-notification');
    }
}
