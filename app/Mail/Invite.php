<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invite extends Mailable
{
    use Queueable, SerializesModels;

    public $invitee_name;
    public $invitee_email;
    public $sender;
    public $sender_name;
    public $invite_code;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invite_code,  $invitee_name, $invitee_email, $sender,  $sender_name, $message)
    {
        $this->invite_code = $invite_code;
        $this->invitee_name = $invitee_name;
        $this->invitee_email = $invitee_email;
        $this->sender = $sender;
        $this->sender_name = $sender_name;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->sender, $this->sender_name)
            ->to($this->invitee_email, $this->invitee_name)
            ->Subject('Invitation To join TOFFEE TRIBE')
            ->markdown('Emails.user-invite');

    }
}
