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
    }
}