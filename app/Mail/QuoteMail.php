<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class QuoteMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('Quote From Starbuck')->view('emails.quoteMail');
        $quote = $this->mailData['quote'];
        if (count($quote->documents)>0){
            foreach ($quote->documents as $doc){
                $link = Storage::url($doc['uploaded_file']);
                $mail->attach($link, [
                    'as' => $doc['title'],
                    'mime' => mime_content_type($link),
                ]);
            }
        }
        return $mail;
    }
}
