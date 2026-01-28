{{-- Adal Khan --}}

@extends('layouts.admin')
@section('title', 'Feedback Dashboard')
@section('admin_contents')
<div class="p-3 sm:p-4">
    <div class="bg-white rounded-sm border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse text-center">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-3 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wide border border-slate-200">
                            Name
                        </th>
                        <th class="px-3 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wide border border-slate-200">
                            Designation
                        </th>
                        <th class="px-3 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wide border border-slate-200">
                            Phone
                        </th>
                        <th class="px-3 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wide border border-slate-200">
                            Satisfaction
                        </th>
                        <th class="px-3 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wide border border-slate-200">
                            SMS Status
                        </th>
                        <th class="px-3 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wide border border-slate-200">
                            Report
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($feedback as $item)
                        <tr class="hover:bg-slate-50 transition">
                            {{-- Name --}}
                            <td class="px-3 py-2 border border-slate-200 font-medium text-slate-700 whitespace-nowrap">
                                {{ $item->name }}
                            </td>

                            {{-- Designation --}}
                            <td class="px-3 py-2 border border-slate-200 text-slate-600 whitespace-nowrap">
                                {{ $item->designation }}
                            </td>

                            {{-- Phone --}}
                            <td class="px-3 py-2 border border-slate-200 text-slate-600 whitespace-nowrap">
                                {{ $item->phone }}
                            </td>

                            {{-- Satisfaction --}}
                            <td class="px-3 py-2 border border-slate-200">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-24 bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                        <div
                                            class="h-full rounded-full
                                            {{ $item->satisfaction_level >= 70 ? 'bg-green-500' :
                                               ($item->satisfaction_level >= 40 ? 'bg-amber-500' : 'bg-red-500') }}"
                                            style="width: {{ $item->satisfaction_level }}%">
                                        </div>
                                    </div>
                                    <span class="text-xs font-medium text-slate-600">
                                        {{ $item->satisfaction_level }}%
                                    </span>
                                </div>
                            </td>

                            {{-- SMS Status --}}
                            <td class="px-3 py-2 border border-slate-200">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold
                                    {{ $item->sms_status === 'sent'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($item->sms_status) }}
                                </span>
                            </td>

                            {{-- Report --}}
                            <td class="px-3 py-2 border border-slate-200">
                                <span class="inline-flex items-center px-3 py-0.5 rounded-md text-[11px] font-semibold
                                       bg-green-300 cursor-not-allowed">
                                    <a href="{{ route('feedback.report', $item->id) }}" class="btn btn-sm">
    View Report
</a>
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-8 border border-slate-200 text-center text-slate-400 italic">
                                No feedback found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $feedback->links() }}
        <p class="mt-2 text-[11px] text-center text-slate-400 uppercase tracking-wider">
            Page {{ $feedback->currentPage() }}
        </p>
    </div>
</div>
@endsection
