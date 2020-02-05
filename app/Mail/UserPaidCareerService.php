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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, ProductOption $product_option)
    {
        $this->user = $user;
        $this->product_option = $product_option;
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
