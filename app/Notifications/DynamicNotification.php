<?php

namespace App\Notifications;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

class DynamicNotification extends Notification
{
    use Queueable;

    protected $templateName;
    protected $placeholders;

    /**
     * Create a new notification instance.
     *
     * @param string $templateName
     * @param array $placeholders
     */
    public function __construct($templateName, array $placeholders = [])
    {
        $this->templateName = $templateName;
        $this->placeholders = $placeholders;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param object $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param object $notifiable
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $template = EmailTemplate::where('name', $this->templateName)->first();

        if (!$template) {
            // Fallback or log error
            return (new MailMessage)
                ->subject('Notification from ' . config('app.name'))
                ->line('Your notification template "' . $this->templateName . '" was not found.');
        }

        $subject = $this->replacePlaceholders($template->subject, $notifiable);
        $body = $this->replacePlaceholders($template->body, $notifiable);

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.dynamic', ['body' => new \Illuminate\Support\HtmlString($body)]);
    }

    /**
     * Replace placeholders in a string.
     *
     * @param string $content
     * @param object $notifiable
     * @return string
     */
    protected function replacePlaceholders($content, $notifiable)
    {
        $data = array_merge([
            'app_name' => config('app.name'),
            'user_name' => $notifiable->name ?? 'User',
            'year' => date('Y'),
        ], $this->placeholders);

        foreach ($data as $key => $value) {
            $content = str_replace('{{ ' . $key . ' }}', $value, $content);
            $content = str_replace('{{' . $key . '}}', $value, $content); // Handle without spaces
        }

        return $content;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param object $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'template' => $this->templateName,
            'placeholders' => $this->placeholders,
        ];
    }

    /**
     * Get the template name.
     *
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }
}
