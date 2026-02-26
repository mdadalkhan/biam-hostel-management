<?php
/**
 * @author <mdadalkhan@gmail.com>
 * @created_at: 18/02/2026
 * @updated_at: 18/02/2026
 * */
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Exception;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void 
    {
        DB::beginTransaction();

        try {
            User::factory()->create([
                'name'     => 'Adal Khan',
                'email'    => 'admin@biam',
                'password' => bcrypt('biam1234')
            ]);

            $this->call([
                FeedbackSeeder::class,
                RoomSeeder::class,
                SeatsSeeder::class
            ]);

            DB::commit();
            $this->command->info('Database seeded successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            $this->command->error('Seeding failed: ' . $e->getMessage());
        }
    }
}