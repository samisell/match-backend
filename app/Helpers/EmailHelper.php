<?php

namespace App\Helpers;

use App\Mail\DynamicMailable;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailHelper
{
    public static function sendDynamicEmail(string $templateName, string $toEmail, array $data = [])
    {
        try {
            $template = EmailTemplate::where('name', $templateName)->first();

            if (!$template) {
                Log::warning("Email template '{$templateName}' not found. Email not sent to {$toEmail}.");
                return false;
            }

            Mail::to($toEmail)->send(new DynamicMailable($template, $data));
            Log::info("Dynamic email '{$templateName}' sent successfully to {$toEmail}.");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send dynamic email '{$templateName}' to {$toEmail}: " . $e->getMessage());
            return false;
        }
    }
}