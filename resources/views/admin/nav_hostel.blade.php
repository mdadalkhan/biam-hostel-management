@extends('layouts.admin')
@section('admin_contents')

@php
    $currentTab = request()->query('tab', 'seats');
    
    $navItems = [
        ['id' => 'seats', 'label' => 'Seats', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
        ['id' => 'add_seat', 'label' => 'Add Seat', 'icon' => 'M12 4v16m8-8H4'],
        // Renamed from delete_seat to edit_info
        ['id' => 'edit_info', 'label' => 'Edit Info', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
        ['id' => 'checkin', 'label' => 'Check-in', 'icon' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1'],
        ['id' => 'requests', 'label' => 'Requests', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9']
    ];
@endphp

<div class="h-full flex flex-col p-3 overflow-hidden font-['Inter',sans-serif] select-none bg-slate-50">
    <div class="flex-1 flex flex-col w-full max-w-6xl mx-auto bg-white border border-slate-300 rounded-sm shadow-lg shadow-slate-200/50 overflow-hidden min-h-0">
        
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 bg-white shrink-0">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-700 p-1.5 rounded-sm shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="text-sm font-black text-slate-800 uppercase tracking-tighter">BIAM Hostel Management</span>
            </div>

            <div class="flex bg-slate-100 p-1 rounded-sm border border-slate-200">
                @foreach($navItems as $t)
                    <a href="?tab={{ $t['id'] }}" 
                       class="px-3 py-1.5 rounded-sm text-[11px] font-bold uppercase tracking-wide transition-all border flex items-center space-x-2 {{ $currentTab === $t['id'] ? 'bg-white text-blue-700 shadow-sm border-slate-200' : 'text-slate-500 border-transparent hover:text-slate-700' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $t['icon'] }}"/></svg>
                        <span>{{ $t['label'] }}</span>
                        @if($t['id'] === 'requests')
                            <span class="ml-1">({{ $requests_count ?? 0 }})</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex-1 flex flex-col min-h-0 overflow-hidden relative">
            <div class="h-full overflow-y-auto custom-scrollbar p-6">
                @switch($currentTab)
                    @case('seats')
                        @include('admin.hostels.tab_seats')
                        @break
                    @case('add_seat')
                        @include('admin.hostels.tab_add_seat')
                        @break
                    @case('edit_info')
                        @include('admin.hostels.tab_edit_seat')
                        @break
                    @case('checkin')
                         @include('admin.hostels.tab_check-in')
                         @break
                    @case('requests')
                        <p class="text-slate-400">Requests Content...</p>
                        @break
                    @default
                        @include('admin.hostels.tab_seats')
                @endswitch
            </div>
        </div>

        <div class="px-4 py-2 border-t border-slate-200 bg-slate-50 flex justify-between items-center shrink-0">
            <div class="flex items-center space-x-2">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                <span class="text-[10px] text-slate-500 font-bold tracking-tight">gRPC Connected!</span>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection