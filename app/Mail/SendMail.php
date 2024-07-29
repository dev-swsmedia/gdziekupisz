<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    
    private $data;
    
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->data['subject'])->markdown('emails.blank', $this->data);
        
        if($this->data['attachments'] !== false && is_array($this->data['attachments']))
        {
            foreach($this->data['attachments'] as $att)
            {
                $mail = $mail->attach($att);
            }
        }
        
        return $mail;
    }
}
