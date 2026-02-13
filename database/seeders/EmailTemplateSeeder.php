<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmailTemplate::firstOrCreate(
            ['name' => 'user_welcome'],
            [
                'subject' => 'Welcome to {{ app_name }}!',
                'body' => '<h1>Welcome, {{ user_name }}!</h1>
                           <p>Thank you for registering at {{ app_name }}.</p>
                           <p>You can log in here: <a href="{{ login_link }}">{{ login_link }}</a></p>
                           <p>We are excited to have you on board!</p>
                           <p>Best regards,<br>{{ app_name }} Team</p>',
                'type' => 'user'
            ]
        );

        EmailTemplate::firstOrCreate(
            ['name' => 'user_updated'],
            [
                'subject' => 'Your profile at {{ app_name }} has been updated!',
                'body' => '<h1>Hello, {{ user_name }}!</h1>
                           <p>Your profile information at {{ app_name }} has been successfully updated.</p>
                           <p>You can view your updated profile here: <a href="{{ user_profile_link }}">{{ user_profile_link }}</a></p>
                           <p>If you did not make these changes, please contact support immediately.</p>
                           <p>Best regards,<br>{{ app_name }} Team</p>',
                'type' => 'user'
            ]
        );

        EmailTemplate::firstOrCreate(
            ['name' => 'user_deleted'],
            [
                'subject' => 'Your account at {{ app_name }} has been deleted.',
                'body' => '<h1>Hello, {{ user_name }}!</h1>
                           <p>This is to inform you that your account at {{ app_name }} has been successfully deleted.</p>
                           <p>If you believe this was done in error, please contact support.</p>
                           <p>Best regards,<br>{{ app_name }} Team</p>',
                'type' => 'user'
            ]
        );

        EmailTemplate::firstOrCreate(
            ['name' => 'user_login'],
            [
                'subject' => 'New login detected at {{ app_name }}',
                'body' => '<h1>Security Alert: New Login</h1>
                           <p>Hello, {{ user_name }}!</p>
                           <p>We detected a new login to your {{ app_name }} account on {{ login_time }}.</p>
                           <p>If this was you, you can ignore this email. If this wasn\'t you, please change your password immediately.</p>
                           <p>Best regards,<br>{{ app_name }} Team</p>',
                'type' => 'user'
            ]
        );

        EmailTemplate::firstOrCreate(
            ['name' => 'forgot_password'],
            [
                'subject' => 'Reset Your Password - {{ app_name }}',
                'body' => '<h1>Password Reset Request</h1>
                           <p>Hello, {{ user_name }}!</p>
                           <p>You are receiving this email because we received a password reset request for your account.</p>
                           <p><a href="{{ reset_link }}" style="display:inline-block;padding:10px 20px;background:#007bff;color:#fff;text-decoration:none;border-radius:5px;">Reset Password</a></p>
                           <p>If you did not request a password reset, no further action is required.</p>
                           <p>Best regards,<br>{{ app_name }} Team</p>',
                'type' => 'user'
            ]
        );

        EmailTemplate::firstOrCreate(
            ['name' => 'user_match'],
            [
                'subject' => 'You have a new match on {{ app_name }}!',
                'body' => '<h1>It\'s a Match!</h1>
                           <p>Hello, {{ user_name }}!</p>
                           <p>Great news! You have a new match with <strong>{{ matched_user_name }}</strong>.</p>
                           <p>Check out their profile and start a conversation: <a href="{{ match_link }}">{{ match_link }}</a></p>
                           <p>Happy matching!</p>
                           <p>Best regards,<br>{{ app_name }} Team</p>',
                'type' => 'user'
            ]
        );

        EmailTemplate::firstOrCreate(
            ['name' => 'complete_profile_reminder'],
            [
                'subject' => 'Complete your profile on {{ app_name }}',
                'body' => '<h1>Don\'t Miss Out!</h1>
                           <p>Hello, {{ user_name }}!</p>
                           <p>Your profile is missing some details. Completed profiles get 3x more matches!</p>
                           <p><a href="{{ profile_link }}">Complete Your Profile Now</a></p>
                           <p>Best regards,<br>{{ app_name }} Team</p>',
                'type' => 'user'
            ]
        );

        EmailTemplate::firstOrCreate(
            ['name' => 'otp_verification'],
            [
                'subject' => 'Verify your email - {{ app_name }}',
                'body' => '<h1>One-Time Password (OTP)</h1>
                           <p>Hello, {{ user_name }}!</p>
                           <p>Your OTP for email verification is: <strong>{{ otp }}</strong></p>
                           <p>This code will expire in 10 minutes.</p>
                           <p>Best regards,<br>{{ app_name }} Team</p>',
                'type' => 'user'
            ]
        );
    }
}