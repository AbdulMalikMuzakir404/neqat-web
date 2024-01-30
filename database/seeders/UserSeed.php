<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            0 => [
                'name' => 'Developer Neqat',
                'email' => 'developer@gmail.com',
                'email_verified' => 1,
                'email_verified_at' => now(),
                'username' => 'neqatdev',
                'password' => Hash::make('neqatdev'),
                'active' => 1,
                'active_at' => now(),
                'roles' => 'developer',
            ],
            1 => [
                'name' => 'Admin Neqat',
                'email' => 'admin@gmail.com',
                'email_verified' => 1,
                'email_verified_at' => now(),
                'username' => 'admin123',
                'password' => Hash::make('admin123'),
                'active' => 1,
                'active_at' => now(),
                'roles' => 'admin',
            ],
            2 => [
                'name' => 'Officer Neqat',
                'email' => 'officer@gmail.com',
                'email_verified' => 1,
                'email_verified_at' => now(),
                'username' => 'officer123',
                'password' => Hash::make('officer123'),
                'active' => 1,
                'active_at' => now(),
                'roles' => 'officer',
            ],
        ];

        foreach ($users as $key) {
            $user = User::create([
                'name' => $key['name'],
                'email' => $key['email'],
                'email_verified' => $key['email_verified'],
                'email_verified_at' => $key['email_verified_at'],
                'username' => $key['username'],
                'password' => $key['password'],
                'active' => $key['active'],
                'active_at' => $key['active_at'],
            ]);

            $user->assignRole($key['roles']);
        }
    }
}
