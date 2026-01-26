<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('feedback')->insert([
            'room_number' => '423',
            'phone' => '01799729507',
            'name' => 'MD. ADAL KHAN',
            'designation' => 'Assistant Programmer',
            'rating_front_desk_service' => 4,
            'rating_canteen_food' => 3,
            'rating_canteen_staff_service' => 2,
            'rating_room_boys_service' => 1,
            'rating_cleanliness_of_room' => 2,
            'rating_overall_cleanliness_around_room' => 3,
            'rating_washroom_ac_lights_fan' => 4,
            'satisfaction_level' => 100, // 100%
            'sms_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
