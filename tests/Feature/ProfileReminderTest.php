<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DynamicNotification;
use App\Models\EmailTemplate;

class ProfileReminderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create the template
        EmailTemplate::create([
            'name' => 'complete_profile_reminder',
            'subject' => 'Complete your profile',
            'body' => 'Please complete your profile {{ user_name }}',
            'type' => 'user'
        ]);
    }

    public function test_it_sends_reminders_to_incomplete_profiles()
    {
        Notification::fake();

        // User 1: Incomplete profile (missing age, etc)
        $incompleteUser = User::factory()->create([
            'email_verified_at' => now(),
            'age' => null,
            'location' => null,
        ]);

        // User 2: Complete profile
        $completeUser = User::factory()->create([
            'email_verified_at' => now(),
            'age' => 30,
            'location' => 'Lagos',
            'occupation' => 'Engineer',
            'interests' => ['coding'],
        ]);

        // Run the command
        $this->artisan('profile:remind')
             ->expectsOutput('Starting profile completion reminders...')
             ->assertExitCode(0);

        // Assert notification was sent to incomplete user
        Notification::assertSentTo(
            $incompleteUser,
            DynamicNotification::class,
            function ($notification, $channels) {
                return $notification->getTemplateName() === 'complete_profile_reminder';
            }
        );

        // Assert notification was NOT sent to complete user
        Notification::assertNotSentTo(
            $completeUser,
            DynamicNotification::class
        );
    }

    public function test_it_does_not_send_reminders_to_unverified_users()
    {
        Notification::fake();

        // User: Incomplete but unverified
        $unverifiedUser = User::factory()->create([
            'email_verified_at' => null,
            'age' => null,
        ]);

        $this->artisan('profile:remind')->assertExitCode(0);

        Notification::assertNotSentTo(
            $unverifiedUser,
            DynamicNotification::class
        );
    }
}
