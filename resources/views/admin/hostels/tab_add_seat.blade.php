<div class="p-2 sm:p-4 bg-slate-50 text-slate-700 font-sans antialiased" 
     x-data="{ 
        roomNo: '{{ old('room_no') }}',
        seatNo: '{{ old('seat_no') }}',
        get seatPattern() {
            return this.roomNo ? `^${this.roomNo}[A-Z]$` : '.*';
        }
     }">

    <div class="max-w-2xl mx-auto bg-white border border-slate-300 rounded-sm shadow-sm overflow-hidden mt-6">
        <div class="bg-slate-50 border-b border-slate-200 px-5 py-3 flex items-center justify-between">
            <h2 class="text-xs font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Seat
            </h2>
        </div>

        <form action="{{ route('admin.navbar.hostel.save_seat') }}" method="POST" class="p-5 space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Building Name</label>
                    <input type="text" name="building_no" value="{{ old('building_no') }}" required 
                           placeholder="e.g. BIAM Main" 
                           class="w-full px-3 py-1.5 text-sm border border-slate-300 rounded-sm outline-none focus:border-indigo-500 transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Room No (Numeric)</label>
                    <input type="text" name="room_no" x-model="roomNo" required 
                           inputmode="numeric" pattern="[0-9]*"
                           placeholder="604" 
                           class="w-full px-3 py-1.5 text-sm border {{ $errors->has('room_no') ? 'border-rose-400' : 'border-slate-300' }} rounded-sm outline-none focus:border-indigo-500">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Seat ID (Room + Letter)</label>
                    @error('seat_no')
        <p class="text-[9px] text-rose-600 font-bold mt-1 uppercase">
            {{ $message }}
        </p>
    @enderror

                    <input type="text" name="seat_no" x-model="seatNo" required 
                           :pattern="seatPattern"
                           placeholder="604A" 
                           class="w-full px-3 py-1.5 text-sm border {{ $errors->has('seat_no') ? 'border-rose-400' : 'border-slate-300' }} rounded-sm outline-none focus:border-indigo-500">
                    
                    <p x-show="roomNo && seatNo && !new RegExp(seatPattern).test(seatNo)" 
                       class="text-[9px] text-amber-600 font-bold mt-1 uppercase italic">
                        Format: <span x-text="roomNo"></span>[A-Z]
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Room Type</label>
                    <select name="type" class="w-full px-3 py-1.5 text-sm border border-slate-300 rounded-sm bg-slate-50 outline-none">
                        <option value="non_ac" {{ old('type') == 'non_ac' ? 'selected' : '' }}>Non-AC</option>
                        <option value="ac" {{ old('type') == 'ac' ? 'selected' : '' }}>AC Room</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Status</label>
                    <select name="status" class="w-full px-3 py-1.5 text-sm border border-slate-300 rounded-sm bg-slate-50 outline-none">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Occupied</option>
                        <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Rent/Night</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1.5 text-slate-400 text-sm">৳</span>
                        <input type="number" name="rent" value="{{ old('rent') }}" required 
                               placeholder="5500" 
                               class="w-full pl-7 pr-3 py-1.5 text-sm border border-slate-300 rounded-sm outline-none focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Remarks</label>
                <textarea name="comment" rows="1" placeholder="e.g. Window side..." 
                          class="w-full px-3 py-1.5 text-sm border border-slate-300 rounded-sm outline-none focus:border-indigo-500 resize-none">{{ old('comment') }}</textarea>
            </div>

            @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition.opacity.duration.500ms
                 class="flex items-center justify-between bg-emerald-50 border border-emerald-200 text-emerald-800 px-3 py-2 rounded-sm transition-all">
                
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-[11px] font-bold uppercase tracking-tight">{{ session('success') }}</span>
                </div>
                
                <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
            @endif

            <div class="flex items-center justify-end gap-6 pt-4 border-t border-slate-100">
                <button type="reset" @click="roomNo = ''; seatNo = ''" 
                        class="text-[10px] font-bold text-slate-400 hover:text-rose-500 uppercase tracking-widest transition-colors">
                    Clear Form
                </button>
                <button type="submit" 
                        class="px-12 py-2.5 bg-slate-800 text-white text-xs font-bold rounded-sm hover:bg-indigo-600 transition-all uppercase tracking-widest shadow-md active:scale-95">
                    Save Seat
                </button>
            </div>
        </form>
    </div>
</div>