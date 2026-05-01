<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Raw SQL as required by assignment
        DB::statement("
            INSERT INTO users (name, email, password, role, company_id, created_at, updated_at)
            VALUES (
                'Super Admin',
                'superadmin@example.com',
                '" . Hash::make('password') . "',
                'SuperAdmin',
                NULL,
                NOW(),
                NOW()
            )
        ");
    }
}
