@extends('layouts.admin')

@section('admin_contents')
<div class="p-4 bg-slate-50 min-h-screen font-sans text-slate-900">
    <div class="max-w-xl mx-auto bg-white border border-slate-300 shadow-sm rounded-sm">
        
        <div class="px-5 py-4 border-b border-slate-200 flex justify-between items-end bg-slate-50/50">
            <div>
                <h1 class="text-[15px] font-black uppercase tracking-tight leading-none">
                    Edit Seat #{{ $seats->seat_no }}
                </h1>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1.5">
                    Ref: {{ $id }} <span class="mx-1 text-slate-300">|</span> Status: <span class="text-slate-600">{{ $seats->status }}</span>
                </p>
            </div>
            <a href="{{ url('/admin/hostel?tab=edit_info') }}" 
               class="px-3 py-1.5 border border-rose-100 bg-rose-50 text-rose-600 text-[9px] font-black uppercase tracking-widest rounded-sm hover:bg-rose-600 hover:text-white transition-all duration-200">
                Discard Changes
            </a>
        </div>

        <form action="{{ route('admin.navbar.hostel.edit_seat_submit', $id) }}" method="POST" class="p-5">
            @csrf
            @method('POST')

            <div class="grid grid-cols-6 gap-x-3 gap-y-4">
                <div class="col-span-4 space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Building Name</label>
                    <input type="text" name="building_no" value="{{ old('building_no', $seats->building_no) }}" 
                           class="w-full px-3 py-2 border border-slate-300 rounded-sm text-[13px] font-bold focus:border-indigo-600 outline-none uppercase bg-slate-50/30">
                </div>

                <div class="col-span-2 space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Room No</label>
                    <input type="text" name="room_no" value="{{ old('room_no', $seats->room_no) }}" 
                           class="w-full px-3 py-2 border border-slate-300 rounded-sm text-[13px] font-bold focus:border-indigo-600 outline-none bg-slate-50/30">
                </div>

                <div class="col-span-6 space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Seat ID (Format: Room + A/B)</label>
                    <input type="text" name="seat_no" value="{{ old('seat_no', $seats->seat_no) }}" 
                           placeholder="e.g. {{ $seats->room_no }}A"
                           class="w-full px-3 py-2 border @error('seat_no') border-rose-500 @else border-slate-300 @enderror rounded-sm text-[13px] font-mono font-bold text-indigo-600 focus:border-indigo-600 outline-none bg-slate-50/30">
                    
                    @error('seat_no')
                        <p class="text-[9px] font-bold text-rose-600 uppercase tracking-tight italic">{{ $message }}</p>
                    @else
                        <p class="text-[9px] text-slate-400 font-medium uppercase tracking-tight">Must end with A or B exclusively.</p>
                    @enderror
                </div>

                <div class="col-span-3 space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Type</label>
                    <select name="type" class="w-full px-2 py-2 border border-slate-300 rounded-sm text-[12px] font-bold focus:border-indigo-600 outline-none cursor-pointer bg-slate-50/30 uppercase">
                        <option value="ac" {{ old('type', $seats->type) == 'ac' ? 'selected' : '' }}>AC</option>
                        <option value="non-ac" {{ old('type', $seats->type) == 'non-ac' ? 'selected' : '' }}>Non-AC</option>
                    </select>
                </div>

                <div class="col-span-3 space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Status</label>
                    <select name="status" class="w-full px-2 py-2 border border-slate-300 rounded-sm text-[12px] font-bold focus:border-indigo-600 outline-none cursor-pointer bg-slate-50/30 uppercase">
                        <option value="available" {{ old('status', $seats->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="booked" {{ old('status', $seats->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="unavailable" {{ old('status', $seats->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>

                <div class="col-span-6 space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Monthly Rent (৳)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">৳</span>
                        <input type="number" name="rent" value="{{ old('rent', $seats->rent) }}" 
                               class="w-full pl-7 pr-3 py-2 border border-slate-300 rounded-sm text-[14px] font-bold focus:border-indigo-600 outline-none tabular-nums bg-slate-50/30">
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full py-3 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.25em] rounded-sm hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 flex items-center justify-center gap-2 active:scale-[0.99]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Update Registry Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection