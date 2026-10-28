<?php
namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SyncSuperAdmin extends Command
{
    protected $signature = 'admin:sync-super';
    protected $description = 'Create or update the super administrator from environment configuration';

    public function handle(): int
    {
        $email = trim((string) config('super_admin.email', ''));
        $password = (string) config('super_admin.password', '');
        $name = trim((string) config('super_admin.name', 'Суперадминистратор'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 12) {
            $this->error('Set a valid SUPER_ADMIN_EMAIL and a SUPER_ADMIN_PASSWORD of at least 12 characters in .env');
            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $name ?: 'Суперадминистратор';
        $user->password = Hash::make($password);
        $user->role = 'super_admin';
        $user->is_active = true;
        $user->save();

        $this->info('Super administrator synchronized successfully.');
        return self::SUCCESS;
    }
}
