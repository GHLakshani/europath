<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\SiteUser;

class PurchaseAdminMail extends Mailable
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
        return $this->subject('New Image Purchase Received')
                    ->view('emails.purchase_admin')
                    ->with([
                        'user' => $this->user,
                        'details' => $this->details,
                    ])
                    ->attachFromStorage($this->details['payment_slip']);
    }
}
