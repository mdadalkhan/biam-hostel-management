<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Feedback;
use App\Http\Controllers\SmsGetWay; 

class CFeedback extends Controller
{
    public function StoreFeedback(Request $request)
    {
        try { 
            $data = $request->validate([
                'room_number'                            => 'required|string',
                'phone'                                  => 'nullable|string',
                'name'                                   => 'nullable|string',
                'designation'                            => 'nullable|string',
                'rating_front_desk_service'              => 'required|integer|min:1|max:4',
                'rating_canteen_food'                    => 'required|integer|min:1|max:4',
                'rating_canteen_staff_service'           => 'required|integer|min:1|max:4',
                'rating_room_boys_service'               => 'required|integer|min:1|max:4',
                'rating_cleanliness_of_room'             => 'required|integer|min:1|max:4',
                'rating_overall_cleanliness_around_room' => 'required|integer|min:1|max:4',
                'rating_washroom_ac_lights_fan'          => 'required|integer|min:1|max:4',
            ]);

            $ratings = collect($data)->filter(fn($v, $k) => str_starts_with($k, 'rating_'));
            $satisfaction = round(($ratings->sum() / ($ratings->count() * 4)) * 100);

            $feedback = Feedback::create(array_merge($data, [
                'satisfaction_level' => $satisfaction
            ]));

$map = [
    4 => 'Best', 
    3 => 'Good', 
    2 => 'Fair', 
    1 => 'Poor'
];

$sms = "BIAM FEEDBACK: Room:{$feedback->room_number}, {$feedback->name}, {$feedback->designation} " .
       "F.Desk:" . $map[$feedback->rating_front_desk_service] . ", " .
       "Food:" . $map[$feedback->rating_canteen_food] . ", " .
       "Staff:" . $map[$feedback->rating_canteen_staff_service] . ", " .
       "RoomBoy:" . $map[$feedback->rating_room_boys_service] . ", " .
       "Cleanliness:" . $map[$feedback->rating_cleanliness_of_room] . ", " .
       "AC\Fan\Light:" . $map[$feedback->rating_washroom_ac_lights_fan];

            
             Log::info($sms);
              //$CSms = new SmsGetWay();
              //$CSms->SendSMS($feedback, $sms);
            
            return response()->json([
                'message' => 'Feedback submitted successfully',
                'satisfaction_percentage' => $satisfaction
            ], 201);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}