<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\View\View;

class CAdminDashboard extends Controller {
    
    public function adminDashboard(): View {
        $perPage = (int) config('services.pagination.feedback_pagination', 5);
        $feedback = Feedback::latest()->simplePaginate($perPage);
        
        return view('admin.dashboard', compact('feedback'));
    }
   
    public function getIndividualReport(int $id): View {
        $report = Feedback::findOrFail($id);
        return view('admin.feedback_report', compact('report'));
    }

    public function tab(): View {
        return view('admin.user_list');
    }

}