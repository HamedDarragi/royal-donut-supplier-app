<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierMail extends Mailable
{
    use Queueable, SerializesModels;

    public $header;
    public $footer;
    public $order;
    public $supplier;
    public $customer;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order,$header,$footer,$supplier,$customer)
    {
        $this->header = $header;
        $this->footer = $footer;
        $this->order = $order;
        $this->supplier = $supplier;
        $this->customer = $customer;



    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $o = $this->order;
        return $this->subject("Order Number: ". $o->order_number)
            ->view('admin.settings.sendemail',[
            'order' => $this->order,
            'header' => $this->header,
            'footer' => $this->footer,
            'supplier' => $this->supplier,
            'customer' => $this->customer,



        ]);
    }
}
