<header class="h-16 bg-white shadow-sm flex items-center px-4 md:px-8 justify-between border-b border-gray-100 sticky top-0 z-40">
    <div class="flex items-center">
        <a href="/" class="flex flex-col leading-none">
            <span class="font-bold text-slate-800 text-base sm:text-lg uppercase tracking-tight">
                BIAM <span class="text-indigo-600">Foundation</span>
            </span>
            <span class="text-[9px] sm:text-[10px] text-gray-400 font-medium uppercase tracking-widest">
                Feedback Administration
            </span>
        </a>
    </div>
    
    <div class="flex items-center gap-2">
        <div class="flex items-center gap-1.5 bg-gray-50 px-2 py-1.5 rounded-full border border-gray-100">
            <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>
            @auth 
                <span class="text-[10px] xs:text-xs font-bold text-gray-600 uppercase truncate max-w-[80px] sm:max-w-[120px]">
                    {{ auth()->user()->name }}
                </span> 
            @endauth
        </div>

        <a href="#" 
           class="flex items-center justify-center gap-1 text-[10px] font-bold text-white bg-red-600 hover:bg-red-700 px-3 py-2 rounded-md shadow-sm transition-all active:scale-95" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span class="hidden xs:block uppercase">Exit</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </div>
</header>