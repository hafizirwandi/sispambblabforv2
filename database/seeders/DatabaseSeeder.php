<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Akun default untuk dev/testing. Akun produksi asli diimpor manual terpisah.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
            ]
        );

        User::firstOrCreate(
            ['username' => 'operator'],
            [
                'name' => 'Operator',
                'password' => 'password',
                'role' => User::ROLE_OPERATOR,
            ]
        );
    }
}
