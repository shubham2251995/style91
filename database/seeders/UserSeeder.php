<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User if not exists
        User::updateOrCreate(
            ['email' => 'admin@style91.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Regular Users
        $users = [
            [
                'name' => 'Rahul Sharma',
                'email' => 'rahul@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'priya@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ],
            [
                'name' => 'Amit Singh',
                'email' => 'amit@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ],
            [
                'name' => 'Sneha Gupta',
                'email' => 'sneha@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ],
            [
                'name' => 'Vikram Malhotra',
                'email' => 'vikram@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, ['email_verified_at' => now()])
            );

            // Add Address if Address model exists (assuming it does based on file list)
            if (class_exists(\App\Models\Address::class)) {
                \App\Models\Address::create([
                    'user_id' => $user->id,
                    'label' => 'Home',
                    'full_name' => $user->name,
                    'phone' => '9876543210',
                    'email' => $user->email,
                    'address_line_1' => '123, Street Name',
                    'address_line_2' => 'Near Landmark',
                    'city' => 'Mumbai',
                    'state' => 'Maharashtra',
                    'postcode' => '400001',
                    'country' => 'India',
                    'is_default' => true,
                    'type' => 'shipping',
                ]);
            }
        }
    }
}
