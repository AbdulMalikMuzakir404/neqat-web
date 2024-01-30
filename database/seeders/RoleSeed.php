<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'developer',
            'admin',
            'officer',
            'student'
        ];

        foreach ($roles as $key) {
            Role::create([
                'name' => $key,
                'guard_name' => 'web',
            ]);
        }
    }
}
