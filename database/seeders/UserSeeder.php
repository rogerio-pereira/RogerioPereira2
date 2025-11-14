<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rogerio Pereira',
            'email' => 'hi@rogeriopereira.dev',
            'password' => '$2y$12$nwYxaDHh39qSJsogaZmnX.mjVVPdP4GzD8be5pYXRDdsxUSQFkcEy',
        ]);
    }
}
