<?php

namespace App\Mail\Agent;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\PinRequest;

class PinRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pin_request;

    /**
     * Create a new message instance.
     * @param PinRequest $pin_request
     * @return void
     */
    public function __construct(PinRequest $pin_request)
    {
        $this->pin_request = $pin_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'), env('APP_NAME'))
	        ->subject('Pin Codes Purchase Request, Ref: #'.$this->pin_request->ref_no )
	        ->markdown('mail/agent/pin/request');
    }
}
