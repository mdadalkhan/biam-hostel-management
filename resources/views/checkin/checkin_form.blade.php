@extends('layouts.hostel_app')

@section('content')
<div class="bg-slate-50 min-h-screen pb-32 md:pb-12 pt-6" 
     x-data="{ 
        selectedSeats: [],
        checkIn: '{{ date('Y-m-d') }}',
        checkOut: '{{ date('Y-m-d', strtotime('+1 day')) }}',
        guestName: '',
        guestPhone: '',
        acceptTerms: false,
        imagePath: '/images/rooms/',

        getSeatImage(seatNo) {
            return `${this.imagePath}${seatNo}.jpg`;
        },

        toggleSeat(id, no, price) {
            const index = this.selectedSeats.findIndex(s => s.id === id);
            if (index > -1) {
                this.selectedSeats.splice(index, 1);
            } else {
                this.selectedSeats.push({ id, no, price });
            }
        },
        
        get days() {
            const start = new Date(this.checkIn);
            const end = new Date(this.checkOut);
            const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            return diff > 0 ? diff : 0;
        },

        get totalPrice() {
            const dailyTotal = this.selectedSeats.reduce((sum, s) => sum + parseFloat(s.price), 0);
            return this.days * dailyTotal;
        }
     }">

    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-end mb-8 border-b border-slate-200 pb-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 uppercase italic leading-none tracking-tighter">Room {{ $room->room_no }}</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2 italic">Select your preferred seats</p>
            </div>
            <a href="{{ url()->previous() }}" class="hidden md:block text-[10px] font-black uppercase text-slate-400 hover:text-red-600 transition-colors">
                [ Exit Booking ]
            </a>
        </div>

        <form action="" method="POST">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <input type="hidden" name="total_price" :value="totalPrice">
            
            <template x-for="seat in selectedSeats" :key="seat.id">
                <input type="hidden" name="selected_seat_ids[]" :value="seat.id">
            </template>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <div class="lg:col-span-7 space-y-6">
                    
                    <div class="bg-white border border-slate-200 rounded-sm p-4 shadow-sm">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($room->seats as $seat)
                            <div @click="toggleSeat({{ $seat->id }}, '{{ $seat->seat_no }}', {{ $seat->rent }})" 
                                 class="relative cursor-pointer transition-all duration-150"
                                 :class="selectedSeats.some(s => s.id === {{ $seat->id }}) ? 'transform translate-y-0.5' : ''">
                                
                                <div :class="selectedSeats.some(s => s.id === {{ $seat->id }}) ? 'border-indigo-600 bg-indigo-50' : 'border-slate-100 bg-white'"
                                     class="border-2 rounded-sm overflow-hidden transition-all">
                                    
                                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                                        <img :src="getSeatImage('{{ $seat->seat_no }}')" 
                                             class="w-full h-full object-cover"
                                             onerror="this.src='https://placehold.co/400x300?text=Seat+{{ $seat->seat_no }}'">
                                        
                                        <div x-show="selectedSeats.some(s => s.id === {{ $seat->id }})" 
                                             class="absolute inset-0 bg-indigo-600/10 flex items-center justify-center">
                                            <div class="bg-indigo-600 text-white p-1 rounded-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-2 flex justify-between items-center">
                                        <span class="text-[11px] font-black text-slate-900 uppercase">{{ $seat->seat_no }}</span>
                                        <span class="text-[10px] font-bold text-indigo-600">৳{{ number_format($seat->rent) }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-sm p-6 shadow-sm">
                        <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-widest mb-6 border-b pb-2">Guest & Schedule Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase">Full Name</label>
                                <input type="text" name="guest_name" x-model="guestName" placeholder="JOHN DOE" required 
                                       class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-600 p-3 text-xs font-bold outline-none rounded-sm transition-all uppercase">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase">Phone Number</label>
                                <input type="tel" name="phone" x-model="guestPhone" placeholder="017XXXXXXXX" required 
                                       class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-600 p-3 text-xs font-bold outline-none rounded-sm transition-all">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase italic">Check-In Date</label>
                                <input type="date" x-model="checkIn" name="check_in" required
                                       class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold outline-none rounded-sm">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase italic">Check-Out Date</label>
                                <input type="date" x-model="checkOut" name="check_out" required
                                       class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold outline-none rounded-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="fixed bottom-0 left-0 right-0 z-50 bg-slate-900 text-white p-6 lg:relative lg:rounded-sm lg:shadow-2xl lg:sticky lg:top-6 border-t border-white/10 lg:border-none">
                        
                        <div class="mb-6 border-b border-white/10 pb-4" x-show="guestName.length > 0">
                            <p class="text-[9px] font-black opacity-30 uppercase tracking-widest mb-1">Booking for</p>
                            <p class="text-sm font-black text-indigo-400 uppercase italic" x-text="guestName"></p>
                            <p class="text-[10px] font-bold opacity-50" x-text="guestPhone"></p>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-[10px] font-black opacity-40 uppercase tracking-widest italic">Inventory Summary</h3>
                            <button type="button" @click="selectedSeats = []" x-show="selectedSeats.length > 0" class="text-[9px] font-black text-red-400 uppercase underline-offset-4 hover:underline">Reset</button>
                        </div>

                        <div class="hidden lg:block space-y-2 mb-6 max-h-40 overflow-y-auto custom-scrollbar pr-1">
                            <template x-for="seat in selectedSeats" :key="seat.id">
                                <div class="flex items-center justify-between bg-white/5 border border-white/5 p-3 rounded-sm">
                                    <span class="text-[10px] font-black px-2 py-0.5 bg-indigo-600 rounded-sm" x-text="'SEAT '+seat.no"></span>
                                    <span class="text-xs font-black">৳<span x-text="Number(seat.price).toLocaleString()"></span></span>
                                </div>
                            </template>
                            <div x-show="selectedSeats.length === 0" class="text-center py-6 opacity-20 text-[10px] font-black uppercase tracking-[0.3em]">No Selection</div>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-white/5 p-3 rounded-sm border border-white/5">
                                    <p class="text-[8px] font-black opacity-30 uppercase tracking-widest mb-1">Nights</p>
                                    <p class="text-lg font-black leading-none italic"><span x-text="days"></span></p>
                                </div>
                                <div class="bg-white/5 p-3 rounded-sm border border-white/5 text-right">
                                    <p class="text-[8px] font-black opacity-30 uppercase tracking-widest mb-1">Total Seats</p>
                                    <p class="text-lg font-black leading-none italic"><span x-text="selectedSeats.length"></span></p>
                                </div>
                            </div>

                            <div class="pt-2">
                                <p class="text-[10px] font-black opacity-30 uppercase tracking-[0.2em] mb-1">Final Amount</p>
                                <p class="text-5xl font-black tracking-tighter text-white italic leading-none">৳<span x-text="Number(totalPrice).toLocaleString()"></span></p>
                            </div>

                            <div class="flex flex-col gap-2 pt-4">
                                <button type="submit" 
                                        :disabled="selectedSeats.length === 0 || days <= 0 || !acceptTerms"
                                        class="w-full bg-indigo-600 hover:bg-indigo-500 disabled:bg-slate-800 disabled:text-slate-600 py-4 text-[11px] font-black uppercase rounded-sm transition-all shadow-xl active:scale-95 flex items-center justify-center gap-2">
                                    Confirm Reservation
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </button>
                                
                                <a href="{{ url()->previous() }}" class="text-center py-2 text-[9px] font-black uppercase text-slate-500 hover:text-red-500 transition-colors">
                                    [ Cancel & Return ]
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 0px; }
</style>
@endsection