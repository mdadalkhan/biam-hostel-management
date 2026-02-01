@extends('layouts.admin') 

@section('admin_contents') 
<div class="h-auto bg-slate-50 p-2 md:p-6 print:bg-white print:p-0 print:m-0 print:h-auto" x-data>   
    <div class="max-w-5xl mx-auto print:max-w-full print:m-0">       
       
       {{-- Header & Actions --}}
       <div class="flex items-center justify-between mb-4 print:hidden">          
          <h1 class="text-xl font-bold text-slate-800"> Guest ID: #{{ $report->id }}</h1>          
          <div class="flex gap-2">             
             <button @click="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center shadow-lg transition">                
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">                    
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>                
                </svg>                
                Print Report             
             </button>             
             <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-800 flex items-center bg-white px-4 py-2 rounded-lg border border-slate-200">             
             Back             
             </a>          
          </div>        
       </div>        

       {{-- Screen View (Hidden on Print) --}}
       <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 print:hidden">          
          <div class="lg:col-span-4 space-y-4">             
             <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">                
                <div class="flex items-center space-x-3 mb-4">                   
                   <div class="h-10 w-10 bg-slate-800 text-white rounded flex items-center justify-center font-bold">                       
                      {{ substr($report->name ?? 'G', 0, 1) }}                   
                   </div>                   
                   <div>                      
                      <h2 class="text-sm font-bold text-slate-900 leading-tight">{{ $report->name ?? 'Guest' }}</h2>                      
                      <p class="text-xs text-slate-500">{{ $report->designation ?? 'N/A' }}</p>                   
                   </div>                
                </div>                
                <div class="space-y-2 text-xs">                   
                   <div class="flex justify-between">                      
                      <span class="text-slate-500">Room:</span>                      
                      <span class="font-semibold text-slate-700">{{ $report->room_number }}</span>                   
                   </div>                   
                   <div class="flex justify-between">                      
                      <span class="text-slate-500">Phone:</span>                      
                      <span class="font-semibold text-slate-700">{{ $report->phone ?? 'N/A' }}</span>                   
                   </div>                   
                   <div class="flex justify-between items-center pt-2 border-t border-slate-50">                      
                      <span class="text-slate-500">SMS:</span>                      
                      <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $report->sms_status === 'sent' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">                      
                      {{ $report->sms_status }}                      
                      </span>                   
                   </div>                
                </div>             
             </div>             
             <div class="bg-indigo-700 rounded-lg p-4 text-white flex items-center justify-between">                
                <div>                   
                   <p class="text-[10px] uppercase tracking-wider opacity-80 font-semibold">Total Score</p>                   
                   <p class="text-2xl font-black">{{ $report->satisfaction_level }}%</p>                
                </div>                
                <div class="h-12 w-12 rounded-full border-4 border-indigo-500 flex items-center justify-center text-[10px] font-bold text-center leading-tight">                   
                   {{ number_format(($report->satisfaction_level / 100) * 4, 1) }} / 4                
                </div>             
             </div>          
          </div>          
          <div class="lg:col-span-8">             
             <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">                
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Service Ratings.</h3>                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">                    
                   @php                   
                   $ratingData = [                   
                   'Front Desk Service Quality' => $report->rating_front_desk_service,                   
                   'Quality of Canteen Food' => $report->rating_canteen_food,                   
                   'Canteen Staff Service & Behavior' => $report->rating_canteen_staff_service,                   
                   'Room Boys Service & Responsiveness' => $report->rating_room_boys_service,                   
                   'Cleanliness of the Room' => $report->rating_cleanliness_of_room,                   
                   'Overall Cleanliness Around the Room Area' => $report->rating_overall_cleanliness_around_room,                   
                   'Facilities (Washroom, AC, Lights, Fan)' => $report->rating_washroom_ac_lights_fan,                   
                   ];                   
                   @endphp                   
                   @foreach($ratingData as $label => $value)                   
                   @php                   
                   $color = $value >= 4 ? 'bg-emerald-500' : ($value >= 3 ? 'bg-green-400' : ($value >= 2 ? 'bg-amber-400' : 'bg-rose-500'));                   
                   $textColor = str_replace('bg-', 'text-', $color);                   
                   @endphp                   
                   <div class="pb-2 border-b border-slate-50 last:border-0 md:last:border-b">                      
                      <div class="flex justify-between items-center mb-1">                         
                         <span class="text-xs font-semibold text-slate-700">{{ $label }}</span>                         
                         <span class="text-[10px] font-black {{ $textColor }}">{{ $value }}/4</span>                      
                      </div>                      
                      <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">                         
                         <div class="{{ $color }} h-1.5 rounded-full" style="width: {{ ($value / 4) * 100 }}%"></div>                      
                      </div>                   
                   </div>                   
                   @endforeach                
                </div>                
                <div class="mt-4 bg-slate-50 border-l-4 border-indigo-500 p-4 rounded-md shadow-sm">                    
                   <p class="text-sm text-slate-800"><span class="font-semibold">Comment:</span> {{ $report->suggestion ?? 'No suggestion provided.' }}</p>                
                </div>             
             </div>          
          </div>        
       </div>        

       {{-- Print View (Hidden on Screen) --}}
       <div class="hidden print:block print:relative print:top-0">          
          <div class="text-center pb-2 mb-6 border-b border-slate-900">             
             <h1 class="text-2xl tracking-tight text-slate-900">Bangladesh Institute of Administration and Management</h1>                         
             <p class="text-[10px] font-sans mt-0.5 text-slate-600">63 New Eskaton, Dhaka-1217</p>             
             <div class="mt-3 inline-block border border-slate-900 text-slate-900 px-4 py-1 font-sans font-bold uppercase tracking-widest text-[14px]">                
                Audit Report: Guest ID #{{ $report->id }}             
             </div>          
          </div>            

          {{-- UPDATED: Single Column Guest Table --}}
          <table class="w-full border-collapse border border-slate-900 mb-6 text-sm font-sans">             
             <tr>                
                <td class="border border-slate-900 p-2 bg-slate-50 font-bold w-1/3 uppercase text-[11px]">Guest Name</td>                
                <td class="border border-slate-900 p-2 font-medium">{{ $report->name }}</td>             
             </tr>             
             <tr>                
                <td class="border border-slate-900 p-2 bg-slate-50 font-bold uppercase text-[11px]">Room Number</td>                
                <td class="border border-slate-900 p-2 font-bold">{{ $report->room_number }}</td>             
             </tr>             
             <tr>                
                <td class="border border-slate-900 p-2 bg-slate-50 font-bold uppercase text-[11px]">Designation</td>                
                <td class="border border-slate-900 p-2 text-xs">{{ $report->designation ?? 'N/A' }}</td>             
             </tr>             
             <tr>                
                <td class="border border-slate-900 p-2 bg-slate-50 font-bold uppercase text-[11px]">Contact Details</td>                
                <td class="border border-slate-900 p-2 text-xs">{{ $report->phone ?? 'N/A' }}</td>             
             </tr>          
          </table>            

          <h3 class="font-sans font-black border-b border-slate-300 mb-3 pb-1 uppercase text-[14px] tracking-widest text-slate-500">Service Audit Metrics</h3>          
          <div class="space-y-1 mb-6 font-sans">             
             @foreach($ratingData as $label => $value)             
             <div class="flex justify-between items-center py-1 border-b border-slate-100">                
                <span class="text-[12px] font-medium text-slate-700">{{ $label }}</span>                
                <div class="flex gap-4 items-center">                    
                   <div class="flex gap-1.5">
                      @for($i = 1; $i <= 4; $i++)
                         <div class="w-2.5 h-2.5 rounded-full border border-slate-900 {{ $i <= $value ? 'bg-slate-900' : 'bg-transparent' }}"></div>
                      @endfor
                   </div>
                   <span class="font-bold text-[12px] w-8 text-right text-slate-900">{{ $value }} / 4</span>                    
                </div>             
             </div>             
             @endforeach          
          </div>            

          <div class="mb-8">             
             <h3 class="font-sans font-black uppercase text-[12px] tracking-widest mb-1 text-slate-400">Qualitative Observation</h3>             
             <div class="p-3 border border-slate-200 text-xs leading-relaxed text-slate-800 font-serif italic">                
                "{{ $report->suggestion ?? 'No qualitative remarks provided.' }}"             
             </div>          
          </div>            

          <div class="grid grid-cols-2 gap-8 mt-10 font-sans">             
             <div class="p-4 border border-slate-900 flex flex-col items-center justify-center">                
                <p class="text-[8px] uppercase font-bold text-slate-500 tracking-widest mb-0.5">Aggregate Index</p>                
                <p class="text-3xl font-black text-slate-900">{{ $report->satisfaction_level }}%</p>             
             </div>             
             <div class="flex flex-col justify-end items-center">                
                <div class="w-full border-t border-slate-900 text-center pt-2">                    
                   <p class="text-[9px] font-bold uppercase tracking-widest">Authorized Signature</p>                    
                   <p class="text-[7px] text-slate-400 mt-1 italic tracking-normal">Report Generated: {{ date('d M, Y - h:i A') }}</p>                
                </div>             
             </div>          
          </div>        
       </div>    
    </div> 
</div>  

<style>     
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600;900&display=swap');

    @media print {        
       @page { 
           size: A4 portrait; 
           margin: 1.5cm; 
       }        
       html, body {
           height: auto !important;
           overflow: visible !important;
           margin: 0 !important;
           padding: 0 !important;
       }
       body {            
           -webkit-print-color-adjust: exact !important;            
           print-color-adjust: exact !important;            
           background-color: white !important;
           font-family: 'Inter', sans-serif;
           color: black !important;
       }        
       .print-section {
           display: block !important;
           width: 100% !important;
           height: auto !important;
           position: relative !important;
       }
       .font-serif {
           font-family: 'Playfair Display', serif !important;
       }
       nav, sidebar, aside, .sidebar, header, footer, .no-print, .print\:hidden, [role="navigation"] { 
           display: none !important; 
           height: 0 !important;
           margin: 0 !important;
           padding: 0 !important;
       }    
    } 
</style> 
@endsection