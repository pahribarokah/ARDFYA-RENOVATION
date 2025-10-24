<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The contact form data.
     *
     * @var array
     */
    public $contactData;

    /**
     * Create a new message instance.
     *
     * @param array $contactData
     * @return void
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pesan Kontak Website: ' . $this->contactData['subject'])
            ->markdown('emails.contact')
            ->with('contactData', $this->contactData);
    }
} 