<div class="p-4 bg-white min-h-screen text-slate-600 font-sans select-none" 
     x-data="{ 
        search: '', 
        typeFilter: 'all',
        globalUnlocked: false,
        match(type, seatNo, roomNo) {
            const normalizedType = type.toLowerCase().replace('_', '-');
            const matchesType = this.typeFilter === 'all' || normalizedType === this.typeFilter;
            const term = this.search.toLowerCase();
            const matchesSearch = !this.search || 
                                 seatNo.toLowerCase().includes(term) || 
                                 roomNo.toString().includes(term);
            return matchesType && matchesSearch;
        }
     }">
    
    @if(session('success'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-black uppercase tracking-widest rounded-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button @click="$el.parentElement.remove()" class="hover:text-emerald-900">&times;</button>
        </div>
    @endif

    <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-6">
        <div class="flex items-center gap-6">
            <div class="inline-flex bg-slate-100 p-1 rounded-md border border-slate-200">
                <template x-for="t in [
                    {id: 'all', label: 'All Seats'},
                    {id: 'ac', label: 'AC'},
                    {id: 'non-ac', label: 'Non-AC'}
                ]">
                    <button @click="typeFilter = t.id" 
                            :class="typeFilter === t.id ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                            class="px-4 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-sm transition-all duration-200 outline-none">
                        <span x-text="t.label"></span>
                    </button>
                </template>
            </div>

            <label class="flex items-center gap-2 cursor-pointer group border-l border-slate-200 pl-6">
                <div class="relative">
                    <input type="checkbox" x-model="globalUnlocked" class="sr-only">
                    <div class="w-8 h-4 bg-slate-200 rounded-full transition-colors" :class="globalUnlocked ? 'bg-rose-500' : 'bg-slate-200'"></div>
                    <div class="absolute left-0 top-0 w-4 h-4 bg-white border border-slate-300 rounded-full transition-transform transform shadow-sm" :class="globalUnlocked ? 'translate-x-4 border-rose-600' : 'translate-x-0'"></div>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest transition-colors" 
                      :class="globalUnlocked ? 'text-rose-700' : 'text-slate-400'">
                    Unlock Delete
                </span>
            </label>
        </div>

        <div class="relative w-full md:w-72">
            <input type="text" x-model="search" placeholder="Quick Search..." 
                   class="w-full pl-3 pr-10 py-2 text-xs font-bold border border-slate-300 rounded-sm focus:border-slate-800 outline-none transition-all uppercase placeholder:text-slate-300 bg-slate-50/50 focus:bg-white">
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
        </div>
    </div>

    <div class="bg-white border border-slate-300 rounded-sm overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-300 text-[12px] font-black text-slate-500 uppercase tracking-widest">
                        <th class="px-4 py-2 border-r border-slate-200">Building / Block</th>
                        <th class="px-3 py-2 border-r border-slate-200 text-center">Room</th>
                        <th class="px-3 py-2 border-r border-slate-200 text-center">Type</th>
                        <th class="px-3 py-2 border-r border-slate-200 text-center">Seat ID</th>
                        <th class="px-3 py-2 border-r border-slate-200 text-center">Status</th>
                        <th class="px-3 py-2 border-r border-slate-200 text-center">Rent</th>
                        <th class="px-3 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-[12px] font-semibold divide-y divide-slate-200">
                    @forelse($seats as $seat)
                    <tr class="hover:bg-slate-50/50 transition-colors" 
                        x-show="match('{{ $seat->type }}', '{{ $seat->seat_no }}', '{{ $seat->room_no }}')"
                        x-cloak>
                        
                        <td class="px-4 py-1.5 border-r border-slate-100">
                            <span class="text-slate-700 uppercase">{{ $seat->building_no }}</span>
                        </td>

                        <td class="px-3 py-1.5 border-r border-slate-100 text-center">
                            <span class="text-slate-900">{{ $seat->room_no }}</span>
                        </td>

                        <td class="px-3 py-1.5 border-r border-slate-100 text-center">
                            <span class="px-2 py-0.5 border text-[9px] uppercase font-black {{ str_contains(strtolower($seat->type), 'ac') && !str_contains(strtolower($seat->type), 'non') ? 'border-blue-200 text-blue-600 bg-blue-50/50' : 'border-slate-200 text-slate-500 bg-white' }}">
                                {{ str_replace('_', ' ', $seat->type) }}
                            </span>
                        </td>

                        <td class="px-3 py-1.5 border-r border-slate-100 text-center">
                            <span class="inline-block px-2 py-0.5 border border-slate-300 text-indigo-700 bg-white font-mono">
                                {{ $seat->seat_no }}
                            </span>
                        </td>

                        <td class="px-3 py-1.5 border-r border-slate-100 text-center">
                            @php
                                $statusStyle = [
                                    'available' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'booked' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'unavailable' => 'bg-slate-50 text-slate-400 border-slate-200'
                                ];
                            @endphp
                            <span class="inline-block px-2 py-0.5 border text-[9px] uppercase tracking-tighter {{ $statusStyle[$seat->status] ?? 'border-slate-200' }}">
                                {{ $seat->status }}
                            </span>
                        </td>

                        <td class="px-3 py-1.5 border-r border-slate-100 text-center font-mono text-slate-900">
                            ৳{{ number_format($seat->rent, 0) }}
                        </td>

                        <td class="px-3 py-1.5 bg-slate-50/20">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('admin.navbar.hostel.edit_seat_view', $seat->id) }}" 
                                   class="px-3 py-1 border border-slate-800 text-slate-800 hover:bg-slate-800 hover:text-white transition-all text-[9px] uppercase font-black">
                                    Edit
                                </a>

                                <form action="{{ route('admin.navbar.hostel.delete_seat', $seat->id) }}" 
                                      method="POST" 
                                      x-show="globalUnlocked" 
                                      x-cloak
                                      onsubmit="return confirm('DELETE SEAT {{ $seat->seat_no }}?')">
                                    @csrf 
                                    <button type="submit" class="px-3 py-1 bg-rose-600 text-white border border-rose-700 text-[9px] uppercase font-black hover:bg-rose-700 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-slate-300 font-black tracking-widest text-[10px] uppercase">No Records Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 border border-slate-200 bg-slate-50/50 p-2 rounded-sm text-xs">
        {{ $seats->withQueryString()->links() }}
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    .overflow-x-auto::-webkit-scrollbar { height: 4px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: #f8fafc; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>