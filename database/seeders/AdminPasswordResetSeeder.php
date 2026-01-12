<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminPasswordResetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->where('email', 'admin@example.com')->update([
            'password' => Hash::make('nieuw-wachtwoord'),
            'role' => 'practicemanager',
        ]);
    }
}
