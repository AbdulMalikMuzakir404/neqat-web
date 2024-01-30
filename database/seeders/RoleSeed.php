<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
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
            'officer'
        ];

        foreach ($roles as $key) {
            Role::create([
                'name' => $key,
                'guard_name' => 'web',
            ]);
        }
    }
}
