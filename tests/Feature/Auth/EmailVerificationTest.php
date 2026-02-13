<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Carbon\Carbon;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_sends_otp_notification()
    {
        Notification::fake();

        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
        
        $user = User::first();
        $this->assertNotNull($user->otp);
        $this->assertNotNull($user->otp_expires_at);

        Notification::assertSentTo($user, OtpNotification::class);
    }

    public function test_verify_otp_success()
    {
        $user = User::factory()->create([
            'otp' => '123456',
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        $response = $this->postJson('/api/verify-otp', [
            'email' => $user->email,
            'otp' => '123456',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Email verified successfully.']);

        $user->refresh();
        $this->assertNull($user->otp);
        $this->assertNull($user->otp_expires_at);
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_verify_otp_invalid()
    {
        $user = User::factory()->create([
            'otp' => '123456',
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        $response = $this->postJson('/api/verify-otp', [
            'email' => $user->email,
            'otp' => '654321',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['otp']);
    }

    public function test_verify_otp_expired()
    {
        $user = User::factory()->create([
            'otp' => '123456',
            'otp_expires_at' => Carbon::now()->subMinutes(1),
        ]);

        $response = $this->postJson('/api/verify-otp', [
            'email' => $user->email,
            'otp' => '123456',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['otp']);
    }
}
