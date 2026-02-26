@extends('layouts.hostel_app')
@section('content')
<style>
    [x-cloak] { display: none !important; }
</style>

<div class="bg-slate-50 min-h-screen pb-44 md:pb-12" 
     x-data="{ 
        search: '', 
        typeFilter: 'all',
        roomsFound: null,
        isRoomVisible(roomNo, seats) {
            const matchSearch = this.search === '' || roomNo.toString().toLowerCase().includes(this.search.toLowerCase());
            const matchType = this.typeFilter === 'all' || seats.some(s => s.type === this.typeFilter);
            return matchSearch && matchType;
        },
        updateCount() {
            this.$nextTick(() => {
                this.roomsFound = Array.from(document.querySelectorAll('.room-card'))
                    .filter(c => getComputedStyle(c).display !== 'none').length;
            });
        }
     }"
     x-init="updateCount(); $watch('search', () => updateCount()); $watch('typeFilter', () => updateCount())">
    
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 py-3 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 shrink-0">
                    <img src="{{asset('images/bd.svg')}}" alt="Logo" class="w-full h-full object-contain" />
                </div>
                <div class="flex flex-col">
                    <h1 class="text-sm font-black text-slate-900 uppercase tracking-widest leading-tight">
                        BIAM Foundation
                    </h1>
                    <span class="text-[11.5px] text-slate-500 font-medium">
                        Seat Booking System v1.0
                    </span>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4">
                <input x-model="search" type="text" placeholder="Search Room Number..." 
                    class="bg-slate-100 border border-slate-300 rounded-sm px-4 py-2 text-sm outline-none focus:bg-white focus:ring-1 focus:ring-slate-400 w-48 transition-all">
                
                <div class="flex gap-1.5 bg-slate-100 p-1 rounded-sm border border-slate-200">
                    @php
                        $filters = [
                            'all' => ['label' => 'All', 'color' => 'bg-white text-slate-900 border-slate-300', 'icon' => 'M4 6h16M4 12h16M4 18h16'],
                            'normal' => ['label' => 'Normal', 'color' => 'bg-emerald-600 text-white border-emerald-700', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            'ac' => ['label' => 'AC', 'color' => 'bg-blue-600 text-white border-blue-700', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            'vip' => ['label' => 'VIP', 'color' => 'bg-amber-500 text-white border-amber-600', 'icon' => 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z']
                        ];
                    @endphp

                    @foreach($filters as $val => $f)
                        <button @click="typeFilter = '{{ $val }}'" 
                            :class="typeFilter === '{{ $val }}' ? '{{ $f['color'] }} shadow-sm border-1' : 'text-slate-500 border-transparent border-1'" 
                            class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold uppercase rounded-sm transition-all border">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}" />
                            </svg>
                            {{ $f['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-2 md:px-4 mt-6">
        <div x-show="roomsFound === 0" x-cloak class="text-center py-20 bg-white border border-dashed border-slate-300 rounded-lg mx-2">
            <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">No Rooms Match Your Search</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12" x-show="roomsFound > 0 || roomsFound === null">
            @php
                $buildings = [
                    'MB' => ['name' => 'Main Building', 'data' => $mainBuilding, 'color' => 'text-indigo-700', 'border' => 'border-indigo-600', 'btn' => 'bg-indigo-600'],
                    'TB' => ['name' => 'Tower Building', 'data' => $towerBuilding, 'color' => 'text-emerald-700', 'border' => 'border-emerald-600', 'btn' => 'bg-emerald-600']
                ];
            @endphp

            @foreach($buildings as $code => $info)
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2 mx-2 md:mx-0">
                    <h2 class="text-[10px] md:text-xs font-black {{ $info['color'] }} uppercase tracking-widest">{{ $info['name'] }}</h2>
                    <span class="text-[9px] bg-slate-200 text-slate-600 px-2 py-0.5 rounded-sm font-bold uppercase tracking-tighter">{{ $code }}</span>
                </div>

                <div class="grid grid-cols-2 xl:grid-cols-3 gap-2 md:gap-5">
                    @foreach($info['data'] as $room)
                    <div x-show="isRoomVisible('{{ $room->room_no }}', {{ $room->seats->toJson() }})"
                         class="room-card bg-white border-1 {{ $info['border'] }} rounded-sm p-2 pb-14 md:pb-16 shadow-md relative transition-all duration-200">
                        
                        <div class="text-center mb-2 md:mb-3">
                            <span class="text-[10px] md:text-sm font-black uppercase tracking-tight {{ $info['color'] }}">
                                Room {{ $room->room_no }}
                            </span>
                        </div>
                        
                        <div class="border border-slate-100 rounded-sm overflow-hidden bg-white">
                            <div class="bg-slate-50 grid grid-cols-3 px-1 md:px-2 py-1 border-b border-slate-100 text-[7px] md:text-[9px] font-bold text-slate-400 uppercase">
                                <span>Seat</span>
                                <span class="text-center">Type</span>
                                <span class="text-right">Rent</span>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @foreach($room->seats as $seat)
                                <div class="grid grid-cols-3 px-1 md:px-2 py-1.5 items-center">
                                    <span class="text-[9px] md:text-[11px] font-bold text-slate-800">{{ $seat->seat_no }}</span>
                                    <span class="text-[7px] md:text-[9px] font-black uppercase text-center {{ $seat->type == 'vip' ? 'text-amber-500' : ($seat->type == 'ac' ? 'text-blue-500' : 'text-emerald-500') }}">
                                        {{ $seat->type }}
                                    </span>
                                    <span class="text-[9px] md:text-[11px] font-black text-slate-900 text-right">
                                        ৳{{ number_format($seat->rent ?? 0) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="absolute bottom-2 left-1.5 right-1.5">
                            <a href="/checkin/{{ $room->id }}" 
                               class="flex items-center justify-center gap-1 w-full {{ $info['btn'] }} text-white text-[9px] md:text-xs font-black py-2.5 rounded-sm uppercase tracking-tighter shadow-md active:scale-95 transition-all">
                                <span>Book Now</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 px-2 pt-2 pb-3 shadow-[0_-10px_40px_rgba(0,0,0,0.15)] z-50">
        <div class="flex h-12 w-full gap-1">
            @foreach($filters as $val => $f)
                <button @click="typeFilter = '{{ $val }}'" 
                    :class="typeFilter === '{{ $val }}' ? '{{ str_replace('border-', 'border-opacity-100 border-', $f['color']) }} shadow-sm' : 'bg-slate-50 text-slate-500 border-slate-100'" 
                    class="flex-1 flex flex-col items-center justify-center rounded-sm border transition-all">
                    <svg class="w-3.5 h-3.5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}" />
                    </svg>
                    <span class="text-[9px] font-black uppercase tracking-tighter">{{ $f['label'] }}</span>
                </button>
            @endforeach
        </div>
    </div>
</div>
@endsection

<script>
/**
 * STATE MANAGEMENT
 * @author <mdadalkhan@gmail.com>
 * created_at: 26/02/2026
 * updated_at: 27/02/2026
 * --------------------------
 * search: Tracks the text input for room number filtering.
 * typeFilter: Tracks the active category (all, normal, ac, vip).
 * roomsFound: Integer used to show/hide the "No Rooms Found" state.
 * selectedRoom: Stores the ID of the room currently being interacted with.
 * selectedSeats: An array of IDs for the seats chosen within the selected room.
 */

/**
 * isRoomVisible(roomNo, seats)
 * ---------------------------
 * This function handles the real-time client-side search logic.
 * 1. Checks if the 'search' string exists within the 'roomNo'.
 * 2. Checks if 'typeFilter' is 'all' OR if the room contains at least 
 * one seat matching the selected type.
 * Returns true only if both conditions are met.
 */

/**
 * toggleSeat(roomId, seatId)
 * --------------------------
 * The core logic for "Select Room First, then One or More Seats":
 * * 1. Room Validation:
 * If the user clicks a seat in a DIFFERENT room than the one currently 
 * selected, it resets the 'selectedSeats' array and sets the new room.
 * This prevents booking seats across multiple rooms simultaneously.
 * * 2. Multi-Seat Toggle:
 * If the seat is already in the 'selectedSeats' array, it is removed (filter).
 * If the seat is NOT in the array, it is added (push).
 * * 3. Cleanup:
 * If all seats are deselected, 'selectedRoom' is set back to null to 
 * hide the checkout bar.
 */

/**
 * updateCount()
 * -------------
 * Uses this.$nextTick to wait for the DOM to update after filtering.
 * It counts all elements with the '.room-card' class that are not 'display: none'.
 * This count is then used by 'x-show' to display or hide the main grid.
 */

/**
 * DYNAMIC ROUTING (BOOKING LINK)
 * ------------------------------
 * The final 'Book Now' anchor tag uses a template literal to construct:
 * '/checkin/' + selectedRoom + '?seats=' + selectedSeats.join(',')
 * * This sends the room ID as a parameter and the seat IDs as a 
 * comma-separated query string (e.g., /checkin/5?seats=101,102).
 * @end
 */
</script>
