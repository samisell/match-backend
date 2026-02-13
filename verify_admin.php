<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$admin = User::where('is_admin', true)->first();
if ($admin) {
    echo "Current Admin: {$admin->email}, Verified: " . ($admin->email_verified_at ? 'Yes' : 'No') . "\n";
    if (!$admin->email_verified_at) {
        $admin->update(['email_verified_at' => now()]);
        echo "Admin email has been verified.\n";
    }
} else {
    echo "No admin user found.\n";
}
