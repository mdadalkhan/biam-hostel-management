@extends('errors.minimal')
@section('title', __('Locked Out'))
@section('code', '429')
@section('message')
<div class="flex flex-col items-center justify-center space-y-6" 
     x-data="{ 
        seconds: 0,
        totalDuration: {{ $exception->headers['Retry-After'] ?? 60 }},
        init() {
            let endTime = localStorage.getItem('lockout_end_time');
            let now = Math.floor(Date.now() / 1000);

            if (!endTime || now > endTime) {
                endTime = now + this.totalDuration;
                localStorage.setItem('lockout_end_time', endTime);
            }

            this.seconds = endTime - now;

            let timer = setInterval(() => {
                let currentNow = Math.floor(Date.now() / 1000);
                this.seconds = Math.max(0, endTime - currentNow);

                if (this.seconds <= 0) {
                    clearInterval(timer);
                    localStorage.removeItem('lockout_end_time');
                    window.location.href = '{{ route('login') }}';
                }
            }, 1000);
        }
     }">
    
    <div class="text-center space-y-2">
        <h2 class="text-2xl font-boldtext-gray-900">
            {{ __('Security Lockout') }}
        </h2>
        <p class="text-gray-900 max-w-sm mx-auto">
            {{ __('Please wait..') }}
        </p>
    </div>

    <div class="w-full max-w-xs p-10 bg-white rounded-3xl border border-gray-100 shadow-2xl shadow-indigo-100 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gray-50">
            <div class="h-full bg-indigo-600 transition-all duration-1000 ease-linear" 
                 :style="`width: ${(seconds / totalDuration) * 100}%` text-indigo-600">
            </div>
        </div>

        <p class="text-[11px] uppercase tracking-[0.25em] text-gray-400 font-bold mb-4">
            {{ __('Resetting in') }}
        </p>
        
        <div class="text-7xl font-black text-indigo-600 tabular-nums tracking-tighter">
            <span x-text="seconds"></span><span class="text-xl ml-1 text-indigo-300 font-medium">s</span>
        </div>
    </div>

    <div class="flex items-center space-x-3 text-indigo-500">
        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
            <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
            <path class="opacity-80" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-sm font-semibold tracking-wide animate-pulse">
            {{ __('System will auto-redirect...') }}
        </span>
    </div>
</div>
@endsection