<?php
/**
 * @author: MD. ADAL KAHN <mdadalkhan@gmail.com>
 * @created_at 02/02/2026
 * @updated_at 19/02/2026
 * */

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\Seat;

class CAdminNavbar extends Controller {
    public function hostel(): View 
    {  $perPage = (int) config('services.pagination.seat_pagination', 10);
        return view('admin.nav_hostel',[
            'seats'   => Seat::orderBy('seat_id', 'desc')->paginate($perPage),
            'seatsAll' => Seat::orderBy('seat_id', 'desc')->get()
        ]);  
    }
    public function report(): View { 
        $capacity = Seat::where('status', '<>', 'unavailable')->count();
        $occupency = Seat::where('status', 'booked')->count();
        $vacancy   = Seat::where('status', 'available')->count();
        $na        = Seat::where('status', 'unavailable')->count();
        return view('admin.nav_report',[
            'capacity'    => $capacity,
            'occupency'   => $occupency,
            'vacancy'     => $vacancy,
            'unavailable' => $na
        ]);  
    }
    public function checkout(): View { return view('admin.nav_checkout');}
}