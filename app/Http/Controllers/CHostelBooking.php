<?php
/**
 * @author: MD. ADAL KAHN <mdadalkhan@gmail.com>
 * @created_at 25/02/2026
 * @updated_at 25/02/2026
 * */

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\View\View;

class CHostelBooking extends Controller  {
    public function index(): View {
        $rooms = Room::with(['seats' => function ($query) {
            $query->where('status', 'available');
        }])->whereHas('seats', function ($query) {
            $query->where('status', 'available');
        })->get();

        $mainBuilding = $rooms->where('building_no', 'MB');
        $towerBuilding = $rooms->where('building_no', 'TB');
        return view('index', compact('mainBuilding', 'towerBuilding'));
    }

    public function show($id): View {
        $room = Room::with(['seats' => function ($query) {
            $query->where('status', 'available');
        }])->findOrFail($id);

        return view('checkin.select_seat', compact('room'));
    }
}