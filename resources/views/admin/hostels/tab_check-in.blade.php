<section class="flex justify-center py-6 px-4" 
    x-data="{ 
        step: 1, 
        pin: '', 
        error: '',
        loading: false,
        verify() {
            if(this.pin.length < 4) { this.error = 'Enter valid PIN'; return; }
            this.loading = true;
            this.error = '';
            fetch('{{ route('admin.hostel.seats.checkin') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ pin: this.pin })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) { this.step = 2; } 
                else { this.error = data.message; this.pin = ''; }
            })
            .finally(() => this.loading = false);
        }
    }">

    <div class="w-full max-w-md bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden transition-all duration-300">
        
        <div x-show="step === 1" class="p-6" x-transition:enter="transition ease-out duration-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="flex-shrink-0 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-gray-900 leading-none">Hello, {{ explode(' ', auth()->user()->name)[0] }}</h1>
                    <p class="text-[11px] text-gray-500 mt-1 uppercase tracking-wider font-medium">Identity Verification</p>
                </div>
            </div>

            <form @submit.prevent="verify" class="space-y-4">
                <div class="relative">
                    <input type="password" x-model="pin" maxlength="6" inputmode="numeric" placeholder="Enter PIN"
                           class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white text-lg tracking-[0.3em] transition-all text-center">
                    <p x-show="error" x-text="error" class="text-[10px] text-red-500 font-medium mt-1 text-center" x-cloak></p>
                </div>

                <button type="submit" :disabled="loading"
                        class="w-full flex items-center justify-center gap-2 py-3 bg-gray-900 hover:bg-black text-white text-sm font-bold rounded-xl disabled:opacity-50 transition-all active:scale-[0.98]">
                    <span x-show="!loading" class="flex items-center gap-2">
                        Verify and Continue
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </span>
                    <span x-show="loading" class="flex items-center" x-cloak>
                        <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Verifying...
                    </span>
                </button>
            </form>
        </div>

        <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-tighter">Check-in Page</span>
                <div class="flex items-center gap-1.5 px-2 py-1 bg-green-50 rounded-md border border-green-100">
                    <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                    <span class="text-[10px] font-bold text-green-700 uppercase">Secure</span>
                </div>
            </div>
            
            <div class="p-6">
                <div class="bg-indigo-600 rounded-xl p-4 text-white mb-6">
                    <p class="text-[10px] uppercase font-bold opacity-70">Authenticated User</p>
                    <p class="text-lg font-bold leading-tight">{{ auth()->user()->email }}</p>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50">
                        <span class="text-gray-500">Terminal ID</span>
                        <span class="font-mono font-bold text-gray-800">HOSTEL-{{ rand(100,999) }}</span>
                    </div>
                    <div class="flex justify-between text-sm py-2">
                        <span class="text-gray-500">Server Time</span>
                        <span class="font-bold text-gray-800">{{ now()->format('H:i:s') }}</span>
                    </div>
                </div>

                <div class="mt-8">
                    <button class="w-full py-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition uppercase tracking-widest">
                        Initialize Seat Map
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>[x-cloak] { display: none !important; }</style>