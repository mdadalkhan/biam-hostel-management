<?php

/**
 * @author MD. ADAL KHAN <mdadalkhan@gmail.com>
 * @created_at 10/02/2026
 * @updated_at 10/02/2026
 * */

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Exception;
use App\Models\Feedback;

class CAdminNavbarReport extends Controller 
{
    public function getGuestReportSummary(Request $request): View|RedirectResponse 
    {
        try {
       
            $validated = $request->validate([
                'type'      => 'required|in:report,hostel,vacancy',
                'startDate' => 'required|date', 
                'endDate'   => 'required|date|after_or_equal:startDate',
            ]);


            $dbStart = Carbon::parse($validated['startDate'])->startOfDay();
            $dbEnd   = Carbon::parse($validated['endDate'])->endOfDay();
            

            $stats = Feedback::whereBetween('created_at', [$dbStart, $dbEnd])
                ->selectRaw('
                    COUNT(*) as total_count,
                    AVG(rating_front_desk_service) as avg_a,
                    AVG(rating_canteen_food) as avg_b,
                    AVG(rating_canteen_staff_service) as avg_c,
                    AVG(rating_room_boys_service) as avg_d,
                    AVG(rating_cleanliness_of_room) as avg_e,
                    AVG(rating_overall_cleanliness_around_room) as avg_f,
                    AVG(rating_washroom_ac_lights_fan) as avg_g,
                    AVG(satisfaction_level) as avg_h
                ')
                ->first();

            if (!$stats || $stats->total_count === 0) {
                return back()->with('error', 'No feedback entries found for the selected date range.')->withInput();
            }

            $feedbacks = Feedback::whereBetween('created_at', [$dbStart, $dbEnd])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.reports.summary', [
                'type'      => $validated['type'],
                'start'     => $dbStart->format('d M, Y'),
                'end'       => $dbEnd->format('d M, Y'),
                'total'     => $stats->total_count,
                'stats'     => $stats,
                'feedbacks' => $feedbacks
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {

            Log::error("BIAM Feedback Report Error: " . $e->getMessage(), [
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'An unexpected error occurred while generating the report.');
        }
    }
}