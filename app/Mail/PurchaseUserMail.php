<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\SiteUser;

class PurchaseUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $details;

    public function __construct(SiteUser $user, $details)
    {
        $this->user = $user;
        $this->details = $details;
    }

    public function build()
    {
        return $this->subject('Thank you for your purchase')
                    ->view('emails.purchase_user');
    }
}
