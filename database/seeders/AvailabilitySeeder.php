<?php

namespace Database\Seeders;

use App\Models\EmployeeAvailability;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AvailabilitySeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        EmployeeAvailability::truncate();
        User::where('email', 'not like', 'admin@%')->delete();

        // Create dentists
        $dentists = [
            [
                'name' => 'Dr. Anna de Vries',
                'email' => 'anna.dentist@example.com',
                'role' => 'dentist',
                'status' => 'active'
            ],
            [
                'name' => 'Dr. Jan Jansen',
                'email' => 'jan.dentist@example.com',
                'role' => 'dentist',
                'status' => 'active'
            ],
            [
                'name' => 'Dr. Lisa Bakker',
                'email' => 'lisa.dentist@example.com',
                'role' => 'dentist',
                'status' => 'inactive'  // Inactive dentist for testing
            ]
        ];

        // Create assistants
        $assistants = [
            [
                'name' => 'Eva Meijer',
                'email' => 'eva.assistant@example.com',
                'role' => 'assistant',
                'status' => 'active'
            ],
            [
                'name' => 'Tom de Boer',
                'email' => 'tom.assistant@example.com',
                'role' => 'assistant',
                'status' => 'active'
            ]
        ];

        // Create all users
        $users = collect($dentists)->merge($assistants)->map(function ($userData) {
            return User::firstOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, ['password' => bcrypt('password')])
            );
        });

        // Create availability for active users
        $users->filter(fn($user) => $user->status === 'active')
             ->each(function($user) {
            // Add availability for today (happy scenario)
            $this->createAvailability(
                $user->id,
                now()->format('Y-m-d'),
                '09:00:00',
                '17:00:00'
            );

            // Add availability for tomorrow
            $this->createAvailability(
                $user->id,
                now()->addDay()->format('Y-m-d'),
                '09:00:00',
                '17:00:00'
            );
        });
    }

    private function createAvailability($userId, $date, $startTime, $endTime)
    {
        return EmployeeAvailability::create([
            'user_id' => $userId,
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
