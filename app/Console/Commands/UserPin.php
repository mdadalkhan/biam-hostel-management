<?php
/**
 * @author <mdadalkhan@gmail.com>
 * @created_at: 23/02/2026
 * @updated-at: 23/02/2026
 * */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserPin extends Command {
    protected $signature   = 'cmd:pin {email} {action} {pin?} {--admin}';
    protected $description = 'Create, Reset, Verify or Change PIN status';

    public function handle() {
        $email   = $this->argument('email');
        $action  = $this->argument('action');
        $pin     = $this->argument('pin');
        $isAdmin = $this->option('admin');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User not found.");
            return Command::FAILURE;
        }

        switch ($action) {
            case 'set':
                if (!$pin) {
                    $this->error("PIN is required for 'set' action.");
                    return Command::FAILURE;
                }
                $user->pin()->updateOrCreate(
                    ['user_id' => $user->id],
                    ['pin' => Hash::make($pin), 'status' => 'active']
                );
                $this->info("PIN set to 'active' for {$email}.");
                break;

            case 'verify':
                if (!$user->pin) {
                    $this->error("No PIN record found.");
                } elseif ($user->pin->status !== 'active') {
                    $this->error("PIN is currently {$user->pin->status}.");
                } elseif (Hash::check($pin, $user->pin->pin)) {
                    $this->info("PIN is valid.");
                } else {
                    $this->error("Invalid PIN.");
                }
                break;

            case 'status':
                if (!$user->pin) {
                    $this->error("No PIN record exists for this user.");
                    return Command::FAILURE;
                }
                
                $newStatus = $this->choice(
                    "Select new status for {$email}",
                    ['active', 'blocked', 'reset'],
                    0
                );

                $user->pin()->update(['status' => $newStatus]);
                $this->info("Status updated to {$newStatus}.");
                break;

            default:
                $this->error("Invalid action. Use set, verify, or status.");
                return Command::FAILURE;
        }

        if ($isAdmin) {
            $this->warn("Admin override used.");
        }

        return Command::SUCCESS;
    }
}