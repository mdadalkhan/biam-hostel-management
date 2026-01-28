@extends('layouts.admin') 

@section('admin_contents') 
<div class="min-h-screen bg-slate-50 p-2 md:p-6 print:bg-white print:p-0" x-data>    
    <div class="max-w-5xl mx-auto">       
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">                   
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

       <div class="hidden print:block print-section">          
          <div class="text-center pb-6 mb-8 border-b-4 border-double border-slate-900">             
             <h1 class="text-4xl font-serif font-bold tracking-tight text-slate-900">Bangladesh Institute of Administration and Management</h1>             
             <h2 class="text-xl font-sans font-semibold uppercase tracking-[0.2em] mt-1 text-slate-700">(BIAM) Foundation</h2>             
             <p class="text-sm font-sans mt-2 text-slate-600 italic">63 New Eskaton, Dhaka-1217</p>             
             <div class="mt-6 inline-block bg-slate-900 text-white px-6 py-2 font-sans font-bold uppercase tracking-widest text-sm">                
                Official Guest Feedback Audit - #{{ $report->id }}             
             </div>          
          </div>           

          <table class="w-full border-collapse border-2 border-slate-900 mb-8 text-sm font-sans">             
             <tr>                
                <td class="border border-slate-900 p-4 bg-slate-50 font-bold w-1/4 uppercase text-[10px] tracking-wider">Guest Name</td>                
                <td class="border border-slate-900 p-4 w-1/4 text-base font-medium">{{ $report->name }}</td>                
                <td class="border border-slate-900 p-4 bg-slate-50 font-bold w-1/4 uppercase text-[10px] tracking-wider">Room Number</td>                
                <td class="border border-slate-900 p-4 w-1/4 font-black text-xl">{{ $report->room_number }}</td>             
             </tr>             
             <tr>                
                <td class="border border-slate-900 p-4 bg-slate-50 font-bold uppercase text-[10px] tracking-wider">Designation</td>                
                <td class="border border-slate-900 p-4">{{ $report->designation ?? 'N/A' }}</td>                
                <td class="border border-slate-900 p-4 bg-slate-50 font-bold uppercase text-[10px] tracking-wider">Contact</td>                
                <td class="border border-slate-900 p-4">{{ $report->phone ?? 'N/A' }}</td>             
             </tr>          
          </table>           

          <h3 class="font-sans font-black border-b-2 border-slate-900 mb-6 pb-2 uppercase text-xs tracking-[0.2em] text-slate-900">Performance Metrics Audit</h3>          
          <div class="space-y-4 mb-10 font-sans">             
             @foreach($ratingData as $label => $value)             
             <div class="flex justify-between items-center py-2 border-b border-slate-100">                
                <span class="text-sm font-semibold text-slate-700 tracking-tight">{{ $label }}</span>                
                <div class="flex gap-8 items-center">                   
                   <span class="font-black text-sm w-12 text-right">{{ $value }} / 4</span>                   
                   <div class="w-48 bg-slate-100 h-4 rounded-none overflow-hidden border border-slate-200">                      
                      <div class="bg-slate-800 h-full" style="width: {{ ($value / 4) * 100 }}%"></div>                   
                   </div>                
                </div>             
             </div>             
             @endforeach          
          </div>           

          <div class="mb-12">             
             <h3 class="font-sans font-black uppercase text-[10px] tracking-widest mb-3 text-slate-400">Guest Feedback & Observations</h3>             
             <div class="p-6 border-l-4 border-slate-900 bg-slate-50 text-base leading-relaxed text-slate-900 font-serif italic">                
                "{{ $report->suggestion ?? 'No suggestions or remarks provided by the guest.' }}"             
             </div>          
          </div>           

          <div class="grid grid-cols-2 gap-12 mt-20 font-sans">             
             <div class="p-8 border-2 border-slate-900 flex flex-col items-center justify-center">                
                <p class="text-[10px] uppercase font-black text-slate-500 tracking-[0.3em] mb-2">Aggregate Index</p>                
                <p class="text-6xl font-black text-slate-900">{{ $report->satisfaction_level }}%</p>             
             </div>             
             <div class="flex flex-col justify-end items-center">                
                <div class="w-full border-t-2 border-slate-900 text-center pt-4">                   
                   <p class="text-xs font-black uppercase tracking-widest">Authorized Signature</p>                   
                   <p class="text-[9px] text-slate-400 mt-2 tracking-tighter italic">Electronically Validated Report • {{ date('d M, Y - h:i A') }}</p>                
                </div>             
             </div>          
          </div>       
       </div>    
    </div> 
</div>  

<style>    
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600;900&display=swap');

    @media print {       
       @page { size: A4; margin: 1.5cm; }       
       body {           
           -webkit-print-color-adjust: exact !important;           
           print-color-adjust: exact !important;           
           background-color: white !important;
           font-family: 'Inter', sans-serif;
       }       
       .print-section {
           display: block !important;
       }
       .font-serif {
           font-family: 'Playfair Display', serif !important;
       }
       nav, sidebar, .sidebar, header, .no-print, .print\:hidden { display: none !important; }    
    } 
</style> 
@endsection