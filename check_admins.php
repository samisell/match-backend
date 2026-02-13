<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$admins = User::where('is_admin', true)->get();
echo "Admin Users Count: " . $admins->count() . "\n";
foreach ($admins as $admin) {
    echo "ID: {$admin->id}, Email: {$admin->email}, Admin: {$admin->is_admin}, Verified: {$admin->email_verified_at}\n";
}

echo "\nAll Users Summary:\n";
foreach (User::all() as $user) {
    echo "ID: {$user->id}, Email: {$user->email}, Admin: {$user->is_admin}, Verified: " . ($user->email_verified_at ? 'Yes' : 'No') . "\n";
}
