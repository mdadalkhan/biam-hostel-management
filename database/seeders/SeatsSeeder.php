<?php
/**
 * @author <mdadalkhan@gmail.com>
 * @created_at: 18/02/2026
 * @updated_at: 18/02/2026
 * */
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('seats')->insert([
            [
                'room_no'     => '101',
                'seat_no'     => '101A',
                'type'        => 'ac',
                'rent'        => 375.00,
                'building_no' => 'Main',
                'status'      => 'available',
                'comment'     => 'NA',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        ]);
    }
}
