<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void {
        User::create([
            'name'                         => 'Admin',
            'email'                        => 'admin@rouleau.gris',
            'password'                     => Hash::make('Admin@2026'),
            'role'                         => 'admin',
            'is_verified'                  => true,
            'verification_code_expires_at' => now(),
        ]);

        $this->call(CategorySeeder::class);
    }
}