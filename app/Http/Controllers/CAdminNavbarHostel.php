<?php
/**
 * @author: MD. ADAL KAHN <mdadalkhan@gmail.com>
 * @created_at 18/02/2026
 * @updated_at 19/02/2026
 * */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\View\View;

use App\Models\Seat;

class CAdminNavbarHostel extends Controller 
{
    /**
     * @author <mdadalkhan@gmail.com>
     * Save seat information.
     * */
    public function saveSeatInfo(Request $request): RedirectResponse 
    {
        $request->validate([
            'building_no' => 'required|string|max:255',
            'room_no'     => 'required|string|max:50',
            'seat_no'     => 'required|string|max:50|unique:seats,seat_no',
            'type'        => 'required|in:ac,non_ac',
            'status'      => 'required|in:available,booked,unavailable',
            'rent'        => 'required|numeric|min:0',
            'comment'     => 'nullable|string|max:1000',
        ], [
            'seat_no.unique' => 'This Seat ID is already registered in the system.',
        ]);
        Seat::create([
            'building_no' => $request->building_no,
            'room_no'     => $request->room_no,
            'seat_no'     => $request->seat_no,
            'type'        => $request->type,
            'status'      => $request->status,
            'rent'        => $request->rent,
            'comment'     => $request->comment,
        ]);

        return back()->with('success', 'New seat has been successfully added to the registry.');
    }
    /**
     * @author <mdadalkhan@gmail.com>
     * delete seat information.
     * */

   public function deleteSeatInfo(int $id): RedirectResponse {
         $seat = Seat::findOrFail($id);
         $seat->delete();
      return redirect()->back()->with('success', "Record deleted.");
   }

     /**
     * @author <mdadalkhan@gmail.com>
     * Edit seat information.
     * */
     public function editSeatInfoView(int $id): View {
          $seatId = Seat::findOrFail($id);
          return view('admin.hostels.view_edit_form',[
             'id' => $id,
             'seats' => $seatId
          ]);
     }

public function editSeatInfoSubmit(Request $request, int $id): RedirectResponse 
{
    $validated = $request->validate([
        'building_no' => 'required|string|max:255',
        'room_no'     => 'required|string|max:50',
        'seat_no'     => [
            'required',
            'string',
            'max:55',
            'regex:/^' . preg_quote($request->room_no) . '[A-Z]$/',
            'unique:seats,seat_no,' . $id
        ],
        'type'        => 'required|in:ac,non-ac',
        'status'      => 'required|in:available,booked,unavailable',
        'rent'        => 'required|numeric|min:0',
    ], [
        'seat_no.unique' => 'This Seat ID is already registered.',
        'seat_no.regex'  => 'Format must be [Room No] + A-Z (e.g., ' . $request->room_no . 'A).'
    ]);

    $seat = Seat::findOrFail($id);
    $seat->update($validated);

    return redirect()
        ->to('/admin/hostel?tab=edit_info')
        ->with('success', "Seat Registry #{$seat->seat_no} updated successfully.");
}
}