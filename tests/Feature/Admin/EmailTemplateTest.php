<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\EmailTemplate;
use App\Notifications\DynamicNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailTemplateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\EmailTemplateSeeder::class);
    }

    public function test_admin_can_list_email_templates()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)
                         ->getJson('/api/admin/email-templates');

        $response->assertStatus(200)
                 ->assertJsonCount(EmailTemplate::count());
    }

    public function test_non_admin_cannot_list_email_templates()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)
                         ->getJson('/api/admin/email-templates');

        $response->assertStatus(403);
    }

    public function test_admin_can_update_email_template()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $template = EmailTemplate::where('name', 'user_welcome')->first();

        $response = $this->actingAs($admin)
                         ->putJson("/api/admin/email-templates/{$template->id}", [
                             'subject' => 'Updated Welcome Subject',
                             'body' => '<h1>Updated Body with {{ user_name }}</h1>',
                         ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated Welcome Subject', $template->fresh()->subject);
    }

    public function test_dynamic_notification_uses_updated_template()
    {
        Notification::fake();
        
        $template = EmailTemplate::where('name', 'user_welcome')->first();
        $template->update(['subject' => 'Dynamic Subject {{ user_name }}']);

        $user = User::factory()->create(['name' => 'John Doe']);
        $user->notify(new DynamicNotification('user_welcome'));

        Notification::assertSentTo($user, DynamicNotification::class, function ($notification, $channels) use ($user) {
            $mail = $notification->toMail($user);
            return $mail->subject === 'Dynamic Subject John Doe';
        });
    }
}
