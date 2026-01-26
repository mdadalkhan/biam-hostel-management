<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
       
        User::factory()->create([
            'name'     => 'Adal Khan',
            'email'    => 'admin@biam',
            'password' => 'biam1234'
        ]);
         $this->Call([
            FeedbackSeeder::class
        ]);
    }
}
