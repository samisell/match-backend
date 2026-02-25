<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\DynamicNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    /**
     * Handle the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $adminEmail = config('mail.admin_email') ?? env('ADMIN_EMAIL');

        if (!$adminEmail) {
            return response()->json([
                'message' => 'Admin email is not configured. Please try again later.'
            ], 500);
        }

        // Send notification to admin
        Notification::route('mail', $adminEmail)->notify(new DynamicNotification('admin_contact_form', [
            'sender_name' => $request->name,
            'sender_email' => $request->email,
            'contact_subject' => $request->subject,
            'contact_message' => $request->message,
        ]));

        return response()->json([
            'message' => 'Thank you for contacting us. Your message has been sent to our team.'
        ]);
    }
}
