<header class="h-14 bg-white shadow-sm flex items-center px-4 md:px-8 justify-between border-b border-gray-100 sticky top-0 z-40">
    <div class="flex items-center">
        <a href="/" class="flex items-center gap-3 leading-none group">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto object-contain">
            <div class="flex flex-col">
                <span class="font-bold text-slate-800 text-sm sm:text-base uppercase tracking-tight">
                    BIAM <span class="text-indigo-600">Foundation</span>
                </span>
                <span class="text-[8px] sm:text-[9px] text-gray-400 font-medium uppercase tracking-widest">
                    Feedback Tracking System
                </span>
            </div>
        </a>
    </div>
    
    <div class="flex items-center gap-2">
        <div class="flex items-center gap-1.5 bg-gray-50 px-2 py-1 rounded-full border border-gray-100">
            <div class="w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] text-indigo-700 font-bold">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            @auth 
                <span class="text-[10px] font-bold text-gray-600 uppercase truncate max-w-[80px] sm:max-w-[120px]">
                    {{ auth()->user()->name }}
                </span> 
            @endauth
        </div>

        <a href="#" 
           class="flex items-center justify-center gap-1 text-[10px] font-bold text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-md shadow-sm transition-all active:scale-95" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span class="hidden xs:block uppercase">Exit</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </div>
</header>