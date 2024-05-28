<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    protected $pdfContent;

    /**
     * Create a new message instance.
     *
     * @param Invoice $invoice
     * @param string $pdfContent
     * @return void
     */
    public function __construct(Invoice $invoice, $pdfContent)
    {
        $this->invoice = $invoice;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->invoice->from_email, $this->invoice->from_name)
                    ->to($this->invoice->from_email)
                    ->subject('Your Invoice: ' . $this->invoice->invoice_number)
                    ->view('emails.invoice_sent')
                    ->attachData($this->pdfContent, $this->invoice->invoice_number . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
