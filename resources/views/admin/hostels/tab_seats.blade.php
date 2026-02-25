<div class="p-4 bg-[#f8fafc] min-h-screen text-slate-600 font-sans select-none" 
     x-data="{ 
        search: '', 
        typeFilter: 'all',
        match(type, building, room, seat) {
            const normalizedType = type.toLowerCase().replace('_', '-');
            const matchesType = this.typeFilter === 'all' || normalizedType === this.typeFilter;
            const term = this.search.toLowerCase();
            return matchesType && (!this.search || [building, room, seat].some(v => v.toLowerCase().includes(term)));
        }
     }">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div class="flex items-center gap-3">
            <span class="text-[10px] font-black uppercase text-slate-500 tracking-widest">Global Type Filter:</span>
            <div class="flex bg-slate-200/60 p-1 rounded-md border border-slate-200">
                <template x-for="t in ['all', 'ac', 'non-ac']">
                    <button @click="typeFilter = t" 
                            :class="typeFilter === t ? 'bg-white text-slate-900 shadow-sm border-slate-200' : 'text-slate-500 hover:text-slate-800 border-transparent'"
                            class="px-4 py-1 text-[10px] font-black uppercase transition-all border rounded-sm" 
                            x-text="t === 'all' ? 'All Seats' : t"></button>
                </template>
            </div>
        </div>

        <div class="relative w-full md:w-72">
            <input type="text" x-model="search" placeholder="Search across all tables..." 
                   class="w-full pl-9 pr-4 py-2 text-xs font-bold border border-slate-300 rounded-sm focus:border-slate-900 outline-none transition-all uppercase bg-white shadow-sm text-slate-800 placeholder:text-slate-300">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
        </div>
    </div>

    <div class="space-y-16">
        @php
            $sections = [
                ['id' => 'available', 'label' => 'Available Seats', 'color' => 'bg-emerald-600', 'count' => $seatsAll->where('status', 'available')->count()],
                ['id' => 'booked', 'label' => 'Booked Seats', 'color' => 'bg-amber-500', 'count' => $seatsAll->where('status', 'booked')->count()],
                ['id' => 'unavailable', 'label' => 'Maintenance / Unavailable', 'color' => 'bg-rose-600', 'count' => $seatsAll->where('status', 'unavailable')->count()]
            ];
        @endphp

        @foreach($sections as $section)
        <section class="space-y-4">
            <div class="border-b-2 border-slate-200 pb-3">
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-6 {{ $section['color'] }} rounded-full"></div>
                    <h2 class="text-sm font-black uppercase tracking-tight text-slate-900">
                        {{ $section['label'] }} 
                        <span class="ml-1.5 text-slate-400 font-medium">({{ $section['count'] }})</span>
                    </h2>
                </div>
            </div>

            <div class="bg-white border border-slate-300 rounded-sm overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-center border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-300 text-[12px] font-black text-slate-900 uppercase tracking-wider">
                                <th class="px-4 py-2 border-r border-slate-200 text-center">Building / Block</th>
                                <th class="px-3 py-2 border-r border-slate-200 text-center">Room</th>
                                <th class="px-3 py-2 border-r border-slate-200 text-center">Type</th>
                                <th class="px-3 py-2 border-r border-slate-200 text-center">Seat ID</th>
                                <th class="px-4 py-2 text-center">Rent / Night</th>
                            </tr>
                        </thead>
                        <tbody class="text-[12px] font-bold divide-y divide-slate-200">
                            @php $foundInSection = false; @endphp
                            
                            @foreach($seatsAll->where('status', $section['id']) as $seat)
                            @php $foundInSection = true; @endphp
                            <tr class="hover:bg-slate-50 transition-colors" 
                                x-show="match('{{ $seat->type }}', '{{ $seat->building_no }}', '{{ $seat->room_no }}', '{{ $seat->seat_no }}')"
                                x-cloak>
                                
                                <td class="px-4 py-1.5 border-r border-slate-100 uppercase text-slate-800 tracking-tight text-center">
                                    {{ $seat->building_no }}
                                </td>

                                <td class="px-3 py-1.5 border-r border-slate-100 text-center">
                                    <span class="bg-slate-100 px-2 py-0.5 rounded border border-slate-200 text-slate-900 font-extrabold">{{ $seat->room_no }}</span>
                                </td>

                                <td class="px-3 py-1.5 border-r border-slate-100 text-center">
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black border {{ str_contains(strtolower($seat->type), 'ac') && !str_contains(strtolower($seat->type), 'non') ? 'border-blue-300 text-blue-700 bg-blue-50' : 'border-slate-300 text-slate-600 bg-slate-50' }}">
                                        {{ strtoupper(str_replace('_', ' ', $seat->type)) }}
                                    </span>
                                </td>

                                <td class="px-3 py-1.5 border-r border-slate-100 text-center font-mono text-indigo-700 font-extrabold text-[13px]">
                                    {{ $seat->seat_no }}
                                </td>

                                <td class="px-4 py-1.5 text-center font-mono text-slate-900 font-extrabold">
                                    ৳{{ number_format($seat->rent, 0) }}
                                </td>
                            </tr>
                            @endforeach

                            @if(!$foundInSection)
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-slate-300 font-black tracking-widest text-[10px] uppercase italic">
                                    No records found for {{ $section['id'] }}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        @endforeach
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    .overflow-x-auto::-webkit-scrollbar { height: 3px; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
</style>