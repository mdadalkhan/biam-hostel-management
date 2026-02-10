@extends('layouts.admin_reports')

@section('contents')
@php
    $ratingFields = [
        'rating_front_desk_service', 
        'rating_canteen_food', 
        'rating_canteen_staff_service', 
        'rating_room_boys_service', 
        'rating_cleanliness_of_room', 
        'rating_overall_cleanliness_around_room', 
        'rating_washroom_ac_lights_fan'
    ];
@endphp

<div x-data="{ 
        search: '', 
        items: {{ $feedbacks->map(fn($f) => [
            'id' => $f->id,
            'room' => $f->room_number,
            'name' => strtoupper($f->name ?? 'N/A'),
            'desig' => $f->designation ?? '—',
            'scores' => [
                (int)$f->rating_front_desk_service,
                (int)$f->rating_canteen_food,
                (int)$f->rating_canteen_staff_service,
                (int)$f->rating_room_boys_service,
                (int)$f->rating_cleanliness_of_room,
                (int)$f->rating_overall_cleanliness_around_room,
                (int)$f->rating_washroom_ac_lights_fan
            ],
            'percent' => number_format((
                ($f->rating_front_desk_service + 
                 $f->rating_canteen_food + 
                 $f->rating_canteen_staff_service + 
                 $f->rating_room_boys_service + 
                 $f->rating_cleanliness_of_room + 
                 $f->rating_overall_cleanliness_around_room + 
                 $f->rating_washroom_ac_lights_fan) / 28) * 100, 0) . '%',
            'date' => $f->created_at->format('d M Y')
        ])->toJson() }}
    }" 
    class="mx-auto bg-white shadow-2xl border border-gray-200 my-6 rounded-lg 
           w-full max-w-[210mm] xl:max-w-[240mm] 2xl:max-w-[280mm] 
           print:max-w-full print:shadow-none print:border-none print:m-0 print:rounded-none transition-all duration-300">
    
    <div class="flex justify-between items-center p-4 bg-slate-900 border-b border-gray-700 no-print rounded-t-lg">
        <div class="flex items-center gap-4">
            <a href="/admin/report" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-slate-700 rounded-md hover:bg-slate-600 transition-all border border-slate-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                BACK
            </a>
            
            <div class="relative">
                <input x-model="search" type="text" placeholder="Search entries..." 
                       class="text-sm border-none ring-1 ring-slate-700 px-9 py-2 rounded-md w-64 lg:w-96 outline-none focus:ring-1 focus:ring-blue-500 bg-slate-800 text-white placeholder-slate-400">
                <svg class="w-4 h-4 absolute left-3 top-2.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-md text-xs font-black hover:bg-blue-500 transition-all flex items-center gap-2 shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            PRINT LOG
        </button>
    </div>

    <div class="p-10 print:p-0">
        <div class="flex justify-between items-end border-b border-slate-900 pb-3 mb-6">
            <div>
                <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none print:text-2xl">BIAM Foundation</h1>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-[0.3em] mt-2 italic">Guest Feedback Master Log</p>
            </div>
            <div class="text-right leading-none">
                <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Total Records</p>
                <p class="text-3xl font-black text-slate-900 tabular-nums print:text-2xl" x-text="items.filter(i => i.room.includes(search) || i.name.toLowerCase().includes(search.toLowerCase())).length"></p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row justify-between items-center text-xs font-bold text-slate-700 mb-6 bg-slate-50 p-4 border border-slate-200 print:bg-white print:border-black print:p-2 print:mb-4">
            <span class="mb-2 lg:mb-0 uppercase">Period: {{ $start }} — {{ $end }}</span>
            <div class="flex flex-wrap justify-center gap-x-4 gap-y-1 text-[10px] text-slate-500 uppercase">
                <span><b class="text-blue-600">A</b> Front Desk</span> <span><b class="text-blue-600">B</b> Food</span> <span><b class="text-blue-600">C</b> Staff</span> 
                <span><b class="text-blue-600">D</b> Room Boy</span> <span><b class="text-blue-600">E</b> Room Clean</span> <span><b class="text-blue-600">F</b> Area Clean</span> <span><b class="text-blue-600">G</b> Utilities</span>
            </div>
        </div>

        <div class="border border-slate-900 rounded-sm overflow-hidden print:rounded-none">
            <table class="w-full table-fixed border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-white print:bg-gray-100 print:text-black">
                        <th class="w-[8%] py-3 text-[10px] uppercase border-r border-blue-400 print:border-black">Room</th>
                        <th class="w-[32%] py-3 text-[10px] uppercase text-left px-4 border-r border-blue-400 print:border-black">Guest Detail</th>
                        @foreach(['A','B','C','D','E','F','G'] as $h)
                            <th class="w-[5.5%] py-3 text-[10px] border-r border-blue-400 print:border-black">{{ $h }}</th>
                        @endforeach
                        <th class="w-[9%] py-3 text-[10px] bg-blue-800 text-white border-r border-blue-900 print:bg-gray-200 print:text-black print:border-black">H %</th>
                        <th class="w-[12.5%] py-3 text-[10px] text-right px-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 print:divide-black">
                    <template x-for="item in items.filter(i => i.room.includes(search) || i.name.toLowerCase().includes(search.toLowerCase()))" :key="item.id">
                        <tr class="hover:bg-blue-50 transition-colors break-inside-avoid">
                            <td class="text-center py-2 text-xs font-black border-r border-slate-200 print:border-black tabular-nums text-slate-800" x-text="item.room"></td>
                            <td class="px-4 py-2 leading-tight overflow-hidden border-r border-slate-200 print:border-black">
                                <div class="text-[11px] font-black text-slate-900 truncate" x-text="item.name"></div>
                                <div class="text-[10px] text-slate-500 italic truncate" x-text="item.desig"></div>
                            </td>
                            
                            <template x-for="score in item.scores">
                                <td class="text-center py-2 text-xs font-bold border-r border-slate-200 print:border-black tabular-nums"
                                    :class="score <= 2 ? 'bg-red-50 text-red-600 font-black print:bg-white print:text-black print:underline' : 'text-slate-700'"
                                    x-text="score"></td>
                            </template>

                            <td class="text-center py-2 text-xs font-black bg-blue-50 text-blue-900 tabular-nums border-r border-slate-200 print:border-black print:bg-white print:text-black" x-text="item.percent"></td>
                            <td class="px-4 py-2 text-right text-[10px] text-slate-500 font-mono tabular-nums font-bold" x-text="item.date"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-between items-end border-t border-slate-200 print:border-black pt-4 break-inside-avoid">
            <div class="text-[10px] text-slate-400 font-mono italic">
                Verified: {{ now()->format('d M Y H:i') }}
            </div>
            <div class="text-right w-56">
                <div class="border-b border-slate-900 mb-2"></div>
                <p class="text-xs font-black uppercase text-slate-900">Authorized Officer</p>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest">BIAM Administration</p>
            </div>
        </div>
    </div>
</div>

<style>
    @page { size: A4 portrait; margin: 10mm; }
    [x-cloak] { display: none !important; }
    
    table, th, td { border-width: 1px !important; }

    @media print {
        .no-print { display: none !important; }
        body { background: white !important; color: black !important; }
        .max-w-\[210mm\], .xl\:max-w-\[240mm\], .2xl\:max-w-\[280mm\] { max-width: 100% !important; width: 100% !important; }
        
        table { border: 1px solid #000 !important; border-collapse: collapse !important; }
        th, td { border: 1px solid #000 !important; }
        
        .bg-blue-600, .bg-blue-800, .bg-blue-50, .bg-red-50 { background-color: transparent !important; color: black !important; }
        .text-white { color: black !important; }
    }
</style>
@endsection