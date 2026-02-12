<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DynamicMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $emailTemplate;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(EmailTemplate $emailTemplate, array $data = [])
    {
        $this->emailTemplate = $emailTemplate;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Replace placeholders in the subject
        $subject = $this->replacePlaceholders($this->emailTemplate->subject, $this->data);

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Replace placeholders in the body
        $body = $this->replacePlaceholders($this->emailTemplate->body, $this->data);

        return new Content(
            htmlString: $body,
        );
    }

    /**
     * Replace placeholders in a given string.
     */
    protected function replacePlaceholders(string $content, array $data): string
    {
        foreach ($data as $key => $value) {
            $content = str_replace('{{ ' . $key . ' }}', $value, $content);
        }
        return $content;
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