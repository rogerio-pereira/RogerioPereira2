<?php

namespace App\Mail;

use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EbookDownloadEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Purchase $purchase
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Ensure ebook is loaded
        if (! $this->purchase->relationLoaded('ebook')) {
            $this->purchase->load('ebook');
        }

        $ebookName = $this->purchase->ebook->name ?? 'Your Ebook';

        return new Envelope(
            subject: 'Your Ebook Download - '.$ebookName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Ensure relationships are loaded
        if (! $this->purchase->relationLoaded('ebook')) {
            $this->purchase->load('ebook');
        }

        if ($this->purchase->ebook && ! $this->purchase->ebook->relationLoaded('category')) {
            $this->purchase->ebook->load('category');
        }

        $categoryName = $this->purchase->ebook->category->name ?? '';

        // Map category name to view
        $viewMap = [
            'Automation' => 'emails.ebook-download.automation',
            'Marketing' => 'emails.ebook-download.marketing',
            'Software Development' => 'emails.ebook-download.software-development',
        ];

        $view = $viewMap[$categoryName] ?? 'emails.ebook-download.automation';

        return new Content(
            view: $view,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
