<?php

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
    /**
     * Generates a comprehensive Guest Feedback Report.
     * Includes both an aggregated summary and a detailed listing.
     */
    public function getGuestReportSummary(Request $request): View|RedirectResponse 
    {
        try {
            // 1. Strict Validation
            $validated = $request->validate([
                'type'      => 'required|in:report,hostel,vacancy',
                'startDate' => 'required|date', 
                'endDate'   => 'required|date|after_or_equal:startDate',
            ]);

            // 2. Date Normalization
            $dbStart = Carbon::parse($validated['startDate'])->startOfDay();
            $dbEnd   = Carbon::parse($validated['endDate'])->endOfDay();
            
            // 3. Aggregate Statistical Summary (Database Level)
            // This is efficient because it returns only ONE row of data
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

            // 4. Handle "No Data" scenario safely
            if (!$stats || $stats->total_count === 0) {
                return back()->with('error', 'No feedback entries found for the selected date range.')->withInput();
            }

            // 5. Fetch Individual Records for the Detailed List
            // We order by latest entries first
            $feedbacks = Feedback::whereBetween('created_at', [$dbStart, $dbEnd])
                ->orderBy('created_at', 'desc')
                ->get();

            // 6. Return Data to Blade
            return view('admin.reports.summary', [
                'type'      => $validated['type'],
                'start'     => $dbStart->format('d M, Y'),
                'end'       => $dbEnd->format('d M, Y'),
                'total'     => $stats->total_count,
                'stats'     => $stats,
                'feedbacks' => $feedbacks
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handles form validation errors
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            // Logs actual error for debugging and shows a friendly message to user
            Log::error("BIAM Feedback Report Error: " . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'An unexpected error occurred while generating the report.');
        }
    }
}