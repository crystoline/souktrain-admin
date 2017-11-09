<?php

namespace App\Mail\Agent;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\PinRequest;

class PinResponseMail extends Mailable implements ShouldQueue
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
        return $this->from(config('mail.from.address'), config('mail.from.name'))
	        ->subject('Purchase of Pin Codes Complete, Ref: #'.$this->pin_request->ref_no )
	        ->markdown('mail/agent/pin/response');
    }
}
