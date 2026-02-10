<?php
/**
 * @author: MD. ADAL KAHN 
 * <mdadalkhan@gmail.com>
 * 02/02/2026
 * */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Feedback;

use Illuminate\View\View;
use Illuminate\Contracts\Pagination\Paginator;


class CAdminDashboard extends Controller {
    public function adminDashboard(): View {
        /** @var int $perPage */
        $perPage = (int) config('services.pagination.feedback_pagination', 5);
        
        /** @var Paginator $feedback */
        $feedback = Feedback::latest()->simplePaginate($perPage);
        
        return view('admin.dashboard', compact('feedback'));
    }
   


    /**
     * Display a specific feedback report by ID.
     */
    public function getIndividualReport(int $id): View {
        /** @var Feedback $report */
        $report = Feedback::findOrFail($id);
    
        return view('admin.feedback_report', compact('report'));
    }



    /**
     * Display the user list tab.
     */
    public function tab(): View {
        return view('admin.user_list');
    }
}