<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\DynamicNotification;
use Illuminate\Support\Facades\Log;

class SendProfileReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send profile completion reminders to users with incomplete profiles';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting profile completion reminders...');
        
        $users = User::whereNotNull('email_verified_at')->get();
        $sentCount = 0;

        foreach ($users as $user) {
            if (!$user->isProfileComplete()) {
                try {
                    $user->notify(new DynamicNotification('complete_profile_reminder', [
                        'profile_link' => config('app.url') . '/dashboard/profile',
                    ]));
                    $sentCount++;
                    $this->line("Sent reminder to: {$user->email}");
                } catch (\Exception $e) {
                    $this->error("Failed to send reminder to {$user->email}: " . $e->getMessage());
                    Log::error("Profile reminder failed for {$user->email}: " . $e->getMessage());
                }
            }
        }

        $this->info("Completed. Sent {$sentCount} reminders.");
        return Command::SUCCESS;
    }
}
