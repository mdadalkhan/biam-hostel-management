@extends('layouts.admin')

@section('admin_contents')
<div class="p-4 bg-gray-50 min-h-screen">
    {{-- Global Session Error Alert --}}
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-xs rounded-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        
        {{-- Guest Feedback Summary Card --}}
        <div class="bg-white rounded-sm shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center gap-2 font-bold text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Guest Feedback Summary
            </div>
            <div class="p-4">
                <form action="{{route('admin.navbar.report.summary')}}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="type" value="report">
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Start Date</label>
                            <input type="date" name="startDate" value="{{ old('startDate') }}" class="w-full px-2 py-1.5 border @error('startDate') border-red-500 @else border-gray-300 @enderror rounded-sm text-sm focus:ring-1 focus:ring-indigo-500 outline-none">
                            @error('startDate')
                                <p class="text-[9px] text-red-500 mt-1 font-semibold italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">End Date</label>
                            <input type="date" name="endDate" value="{{ old('endDate') }}" class="w-full px-2 py-1.5 border @error('endDate') border-red-500 @else border-gray-300 @enderror rounded-sm text-sm focus:ring-1 focus:ring-indigo-500 outline-none">
                            @error('endDate')
                                <p class="text-[9px] text-red-500 mt-1 font-semibold italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="py-2 border-t border-gray-50 mt-2">
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" name="download" value="1" class="w-4 h-4 text-indigo-600 border-gray-300 rounded-sm focus:ring-indigo-500">
                            <span class="text-sm text-gray-600 group-hover:text-indigo-600 font-medium text-xs">Download as PDF</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 rounded-sm transition shadow-sm flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Generate Report
                    </button>
                </form>
            </div>
        </div>

        {{-- Hostel Occupancy Card --}}
        <div class="bg-white rounded-sm shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center gap-2 font-bold text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Hostel Occupancy Report
            </div>
            <div class="p-4 space-y-4">
                <div class="flex justify-between items-center bg-indigo-50 p-3 rounded-sm border border-indigo-100">
                    <div>
                        <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-tighter">Total Residents</p>
                        <p class="text-2xl font-black text-indigo-700 leading-none">124</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Current Status</p>
                        <p class="text-xs font-bold text-gray-600">88% Capacity</p>
                    </div>
                </div>
                
                <form action="{{route('admin.navbar.report.summary')}}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="type" value="hostel">
                    <div class="py-1 border-b border-gray-50">
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" name="download" value="1" class="w-4 h-4 text-indigo-600 border-gray-300 rounded-sm focus:ring-indigo-500">
                            <span class="text-sm text-gray-600 group-hover:text-indigo-600 font-medium text-xs">Download List as PDF</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full border border-indigo-600 text-indigo-600 hover:bg-indigo-50 text-xs font-bold py-2 rounded-sm transition flex items-center justify-center gap-2 uppercase tracking-tight">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View Residents
                    </button>
                </form>
            </div>
        </div>

        {{-- Vacancy Insights Card --}}
        <div class="bg-white rounded-sm shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center gap-2 font-bold text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" />
                </svg>
                Vacancy Insights
            </div>
            <div class="p-4 space-y-4">
                <div class="flex justify-between items-center bg-green-50 p-3 rounded-sm border border-green-100">
                    <div>
                        <p class="text-[10px] font-bold text-green-500 uppercase tracking-tighter">Available Slots</p>
                        <p class="text-2xl font-black text-green-700 leading-none">16</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Immediate</p>
                        <p class="text-xs font-bold text-gray-600 italic">Ready to move</p>
                    </div>
                </div>

                <form action="{{route('admin.navbar.report.summary')}}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="type" value="vacancy">
                    <div class="py-1 border-b border-gray-50">
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" name="download" value="1" class="w-4 h-4 text-green-600 border-gray-300 rounded-sm focus:ring-green-500">
                            <span class="text-sm text-gray-600 group-hover:text-green-600 font-medium text-xs">Download Vacancy PDF</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 rounded-sm transition flex items-center justify-center gap-2 uppercase tracking-tight">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Get Vacant Rooms
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection