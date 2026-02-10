<?php

/**
 * @author: MD. ADAL KAHN <mdadalkhan@gmail.com>
 * @created_at 01/02/2026
 * @updated_at 10/02/2026
 * */

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\Feedback;
use App\Http\Controllers\SmsGetWay;
use Exception;

class CFeedback extends Controller
{
    public function csrfRefresh() {
       session()->regenerateToken(); 
       return response()->json([
        'csrf_token' => csrf_token()
       ]);

    }

    public function storeFeedback(Request $request): JsonResponse
    {
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
            'suggestion'                             => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $ratings = collect($data)->filter(fn(mixed $v, string $k): bool => str_starts_with($k, 'rating_'));
            $satisfaction = round(($ratings->sum() / ($ratings->count() * 4)) * 100);

            $feedback = Feedback::create(array_merge($data, [
                'satisfaction_level' => (int) $satisfaction
            ]));

            $map = [4 => 'Best', 3 => 'Good', 2 => 'Fair', 1 => 'Poor'];
            
            $sms = "Room No: {$feedback->room_number}, {$feedback->name}, {$feedback->designation} " .
                   "F.Desk:" . ($map[(int)$feedback->rating_front_desk_service] ?? 'N/A') . ", " .
                   "Food:" . ($map[(int)$feedback->rating_canteen_food] ?? 'N/A') . ", " .
                   "Staff:" . ($map[(int)$feedback->rating_canteen_staff_service] ?? 'N/A') . ", " .
                   "Room Boys:" . ($map[(int)$feedback->rating_room_boys_service] ?? 'N/A') . ", " .
                   "Cleanliness:" . ($map[(int)$feedback->rating_cleanliness_of_room] ?? 'N/A') . ", " .
                   "Washroom/AC/Fan:" . ($map[(int)$feedback->rating_washroom_ac_lights_fan] ?? 'N/A');

                  // Log::info($sms); 
                 $CSms = new SmsGetWay();
                 $CSms->SendSMS($feedback, $sms);

            DB::commit();

            $request->session()->regenerateToken();

            return response()->json([
                'status' => 'success',
                'message' => 'Feedback saved and SMS sent',
                'satisfaction' => $satisfaction,
                'new_token' => csrf_token()
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Feedback System Failure: " . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction failed. Data rolled back.'
            ], 500);
        }
    }
}