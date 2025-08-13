<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

// app/Console/Commands/HashPasswords.php


class HashPasswords extends Command
{
    protected $signature = 'users:hash-passwords';
    protected $description = 'Hash existing plain text passwords';

    public function handle()
    {
        $users = User::all();
        
        foreach ($users as $user) {
            // Solo hashear si la contraseña no está ya hasheada
            if (!Hash::needsRehash($user->password)) {
                continue;
            }
            
            $user->update([
                'password' => Hash::make($user->password)
            ]);
        }
        
        $this->info('Passwords hashed successfully!');
    }
}
