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
    public function __construct(User $user, ProductOption $product_option, $amount = 0, $type = null)
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
        switch ($this->type) {
            case 'career-service':
                return $this->from('app@sportsbusiness.solutions')
                    ->subject('Career Service Purchase Notification - theClubhouse')
                    ->markdown('emails.internal.purchase-notification');
                break;
            case 'webinar':
                return $this->from('app@sportsbusiness.solutions')
                    ->subject('Webinar RSVP Notification - theClubhouse')
                    ->markdown('emails.internal.purchase-notification');
                break;
            case 'membership':
                return $this->from('app@sportsbusiness.solutions')
                    ->subject('Membership Purchase Notification - theClubhouse')
                    ->markdown('emails.internal.purchase-notification');
                break;
            case 'job-featured':
                return $this->from('app@sportsbusiness.solutions')
                    ->subject('Job Featured Purchase Notification - theClubhouse')
                    ->markdown('emails.internal.purchase-notification');
                break;
            default:
                return;
        }
    }
}
