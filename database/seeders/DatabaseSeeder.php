<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Define
        $roles = ['SuperAdmin', 'Admin', 'Rider'];

        // Create roles 
        foreach ($roles as $roleName) {
            Role::create(['role_name' => $roleName]);
        }

        Branch::create([
            'branch_name' => 'Main Branch',
            'branch_address' => 'Angeles City, Pampanga'
        ]);

        // Create admin user
        User::create([
            'role_id' => Role::where('role_name', 'SuperAdmin')->first()->id,  // Get Admin role ID dynamically
            'name' => 'SuperAdmin',
            'username' => 'SuperAdmin',
            'email' => 'superadmin@gmail.com',
            'contact_number' => '09999999999',
            'password' => Hash::make('superadmin'),
            'branch_id' => Branch::where('branch_name', 'Main Branch')->first()->id,  // Get Admin department ID dynamically
        ]);

    }
}
