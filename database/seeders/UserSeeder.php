<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Patrik Oroh',
            'email' => 'poroh@app.com',
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johnd@app.com',
            'is_admin' => false
        ]);

        User::factory(18)->create();
    }
}
