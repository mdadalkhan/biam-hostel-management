<?php
/**
 * @author <mdadalkhan@gmail.com>
 * @created_at: 25/02/2026
 * @updated_at: 25/02/2026
 * */


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder {
   
    public function run(): void {
        $rooms = [
            // MB Building
            ['room_no' => '506', 'building_no' => 'MB'],
            ['room_no' => '507', 'building_no' => 'MB'],
            ['room_no' => '508', 'building_no' => 'MB'],
            ['room_no' => '509', 'building_no' => 'MB'],
            ['room_no' => '601', 'building_no' => 'MB'],
            ['room_no' => '602', 'building_no' => 'MB'],
            ['room_no' => '603', 'building_no' => 'MB'],
            ['room_no' => '604', 'building_no' => 'MB'],
            ['room_no' => '605', 'building_no' => 'MB'],
            ['room_no' => '606', 'building_no' => 'MB'],
            ['room_no' => '607', 'building_no' => 'MB'],
            ['room_no' => '608', 'building_no' => 'MB'],
            ['room_no' => '609', 'building_no' => 'MB'],
            ['room_no' => '610', 'building_no' => 'MB'],
            ['room_no' => '701', 'building_no' => 'MB'],
            ['room_no' => '702', 'building_no' => 'MB'],
            ['room_no' => '703', 'building_no' => 'MB'],
            ['room_no' => '704', 'building_no' => 'MB'],
            ['room_no' => '705', 'building_no' => 'MB'],
            ['room_no' => '706', 'building_no' => 'MB'],
            ['room_no' => '801', 'building_no' => 'MB'],
            ['room_no' => '802', 'building_no' => 'MB'],
            ['room_no' => '803', 'building_no' => 'MB'],
            ['room_no' => '804', 'building_no' => 'MB'],
            ['room_no' => '805', 'building_no' => 'MB'],
            ['room_no' => '806', 'building_no' => 'MB'],
            ['room_no' => '807', 'building_no' => 'MB'],
            ['room_no' => '808', 'building_no' => 'MB'],
            ['room_no' => '809', 'building_no' => 'MB'],
            ['room_no' => '810', 'building_no' => 'MB'],
            ['room_no' => '901', 'building_no' => 'MB'],
            ['room_no' => '902', 'building_no' => 'MB'],
            ['room_no' => '903', 'building_no' => 'MB'],
            ['room_no' => '904', 'building_no' => 'MB'],
            ['room_no' => '905', 'building_no' => 'MB'],
            ['room_no' => '906', 'building_no' => 'MB'],
            ['room_no' => '907', 'building_no' => 'MB'],
            ['room_no' => '908', 'building_no' => 'MB'],
            ['room_no' => '909', 'building_no' => 'MB'],
            ['room_no' => '910', 'building_no' => 'MB'],
            ['room_no' => '1001', 'building_no' => 'MB'],
            ['room_no' => '1002', 'building_no' => 'MB'],
            ['room_no' => '1003', 'building_no' => 'MB'],
            ['room_no' => '1004', 'building_no' => 'MB'],
            ['room_no' => '1005', 'building_no' => 'MB'],
            ['room_no' => '1006', 'building_no' => 'MB'],
     
            // TB Building
            ['room_no' => '6001', 'building_no' => 'TB'],
            ['room_no' => '6002', 'building_no' => 'TB'],
            ['room_no' => '6003', 'building_no' => 'TB'],
            ['room_no' => '6004', 'building_no' => 'TB'],
            ['room_no' => '6005', 'building_no' => 'TB'],
            ['room_no' => '6006', 'building_no' => 'TB'],
            ['room_no' => '7001', 'building_no' => 'TB'],
            ['room_no' => '7002', 'building_no' => 'TB'],
            ['room_no' => '7003', 'building_no' => 'TB'],
            ['room_no' => '7004', 'building_no' => 'TB'],
            ['room_no' => '7005', 'building_no' => 'TB'],
            ['room_no' => '7006', 'building_no' => 'TB'],
            ['room_no' => '8001', 'building_no' => 'TB'],
            ['room_no' => '8002', 'building_no' => 'TB'],
            ['room_no' => '8003', 'building_no' => 'TB'],
            ['room_no' => '8004', 'building_no' => 'TB'],
            ['room_no' => '8005', 'building_no' => 'TB'],
            ['room_no' => '8006', 'building_no' => 'TB'],
            ['room_no' => '9001', 'building_no' => 'TB'],
            ['room_no' => '9002', 'building_no' => 'TB'],
            ['room_no' => '9003', 'building_no' => 'TB'],
            ['room_no' => '9004', 'building_no' => 'TB'],
            ['room_no' => '9005', 'building_no' => 'TB'],
            ['room_no' => '9006', 'building_no' => 'TB'],
            ['room_no' => '9007', 'building_no' => 'TB'],
            ['room_no' => '10001', 'building_no' => 'TB'],
            ['room_no' => '10002', 'building_no' => 'TB'],
            ['room_no' => '10003', 'building_no' => 'TB'],
            ['room_no' => '10004', 'building_no' => 'TB'],
            ['room_no' => '10005', 'building_no' => 'TB'],
            ['room_no' => '10006', 'building_no' => 'TB'],
            ['room_no' => '10007', 'building_no' => 'TB'],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->updateOrInsert(
                ['room_no' => $room['room_no']], 
                ['building_no' => $room['building_no'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
