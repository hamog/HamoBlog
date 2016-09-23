<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The request instance
     *
     * @var object $request
     */
    protected $request;

    /**
     * Create a new message instance.
     *
     * @param object $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->request->input('email'), $this->request->input('name'))
                    ->subject('Test Email')
                    ->view('emails.contact')
                    ->with([
                        'name' => $this->request->input('name'),
                        'text' => $this->request->input('message'),
                    ]);
    }
}
