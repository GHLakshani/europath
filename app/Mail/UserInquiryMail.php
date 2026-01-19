<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\SiteUser;

class UserInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $inquiry;

    public function __construct(SiteUser $user, $inquiry)
    {
        $this->user = $user;
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        return $this->subject('New Inquiry Received')
                    ->view('emails.inquiry')
                    ->with([
                        'user' => $this->user,
                        'inquiry' => $this->inquiry,
                    ]);
    }
}
