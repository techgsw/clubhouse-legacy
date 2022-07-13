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
                return $this->from(__('email.support_address'))
                    ->subject('Career Service Purchase Notification - theClubhouse®')
                    ->markdown('emails.internal.purchase-notification');
                break;
            case 'webinar':
                return $this->from(__('email.support_address'))
                    ->subject('Webinar RSVP Notification - theClubhouse®')
                    ->markdown('emails.internal.purchase-notification');
                break;
            case 'membership':
                return $this->from(__('email.support_address'))
                    ->subject('Membership Purchase Notification - theClubhouse®')
                    ->markdown('emails.internal.purchase-notification');
                break;
            case 'premium-job':
                return $this->from(__('email.support_address'))
                    ->subject('Preimium Job Purchase Notification - theClubhouse®')
                    ->markdown('emails.internal.purchase-notification');
                break;
            case 'premium-job-upgrade':
                return $this->from(__('email.support_address'))
                    ->subject('Preimium Job Upgrade Purchase Notification - theClubhouse®')
                    ->markdown('emails.internal.purchase-notification');
                break;
            case 'platinum-job':
                return $this->from(__('email.support_address'))
                    ->subject('Platinum Job Purchase Notification - theClubhouse®')
                    ->markdown('emails.internal.purchase-notification');
                break;
            case 'platinum-job-upgrade':
                return $this->from(__('email.support_address'))
                    ->subject('Platinum Job Upgrade Purchase Notification - theClubhouse®')
                    ->markdown('emails.internal.purchase-notification');
                break;
            default:
                return;
        }
    }
}
