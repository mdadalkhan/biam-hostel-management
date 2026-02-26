<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Room;

class CAdminHostelCheckin extends Controller {
    public function showCheckinForm(int $id): View {
        $room = Room::with('seats')->findOrFail($id);
        return view('checkin.checkin_form', compact('room'));
    }
}
