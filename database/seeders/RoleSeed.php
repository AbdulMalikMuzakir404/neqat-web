<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

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
                'id' => Str::uuid(),
                'name' => $key,
                'guard_name' => 'web',
            ]);
        }
    }
}
