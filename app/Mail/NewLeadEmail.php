<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewLeadEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Contact $contact,
        public string $category
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjects = [
            'automation' => 'Your Free Automation Guide - 10 Strategies to Save Hours Every Week',
            'marketing' => 'Your Free Marketing Strategy Guide - Compete with Bigger Budgets',
            'software-development' => 'Let\'s Build Your Software Project Together',
        ];

        $subject = $subjects[$this->category] ?? 'Your Free Guide';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Map category to view
        $viewMap = [
            'automation' => 'emails.new-lead.automation',
            'marketing' => 'emails.new-lead.marketing',
            'software-development' => 'emails.new-lead.software-development',
        ];

        $view = $viewMap[$this->category] ?? 'emails.new-lead.automation';

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
