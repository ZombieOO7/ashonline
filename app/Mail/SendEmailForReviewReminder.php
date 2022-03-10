<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailForReviewReminder extends Mailable
{
    use Queueable, SerializesModels;
    protected $details;
    protected $user;
    /**
     * Create a new message instance.
     */
    public function __construct($details,$user)
    {
        $this->details = $details;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject($this->details['subject'])
            ->markdown('mail.review_reminder_email')
            ->with(['content' => $this->details['body'],'url' => $this->details['actionURL'],'thanks' => $this->details['thanks'],'order' => $this->details['order'],'billingAddress' => $this->details['billingAddress'],'item' => $this->details['item']]);

    }
}
