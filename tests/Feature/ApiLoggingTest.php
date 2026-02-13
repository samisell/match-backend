<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Models\ActivityLog;

class ApiLoggingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_api_requests_to_file()
    {
        $spy = Log::spy();
        Log::shouldReceive('channel')->with('api')->andReturn($spy);

        $user = User::factory()->create();

        $this->actingAs($user)->getJson('/api/user')->assertStatus(200);

        $spy->shouldHaveReceived('info');
    }

    public function test_it_masks_sensitive_data_in_logs()
    {
        $spy = Log::spy();
        Log::shouldReceive('channel')->with('api')->andReturn($spy);
        Log::shouldReceive('error')->any();

        $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'secret_password_123',
            'otp' => '123456'
        ]);

        $this->assertEquals(1, ActivityLog::count());
        $log = ActivityLog::first();
        $this->assertEquals(401, $log->status);
        
        $spy->shouldHaveReceived('info', function ($message, $data) {
            return $data['request_body']['password'] === '********' &&
                   $data['request_body']['otp'] === '********';
        });
    }

    public function test_it_logs_error_responses()
    {
        $spy = Log::spy();
        Log::shouldReceive('channel')->with('api')->andReturn($spy);
        Log::shouldReceive('error')->any();

        $this->postJson('/api/register', [
            'name' => '', 
        ]);

        $spy->shouldHaveReceived('info');
    }
}
