<x-admin-layout title="Dashboard Overview">
    <div class="space-y-6">

        {{-- Page heading --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-900">
                    Good morning, {{ explode(' ', Auth::user()->name)[0] }} 👋
                </h1>
                <p class="text-sm text-slate-500 mt-0.5">Here's what's happening at Ogechi Hospital today.</p>
            </div>
            <div class="hidden sm:flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-600 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ now()->format('l, d M Y') }}
            </div>
        </div>

        {{-- ── STAT CARDS ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Patients --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-4">
                <div class="bg-blue-50 w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-slate-900">{{ number_format($totalPatients) }}</p>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Total Patients</p>
                </div>
            </div>

            {{-- Doctors --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-4">
                <div class="bg-amber-50 w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-slate-900">{{ number_format($totalDoctors) }}</p>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Total Doctors</p>
                </div>
            </div>

            {{-- Appointments Today --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-4">
                <div class="bg-teal-50 w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-slate-900">{{ number_format($todayAppointments) }}</p>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Appointments Today</p>
                    <p class="text-[11px] mt-1 font-medium {{ $pendingAppointments > 0 ? 'text-amber-500' : 'text-slate-400' }}">
                        {{ $pendingAppointments }} pending
                    </p>
                </div>
            </div>

            {{-- Monthly Revenue --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-4">
                <div class="bg-rose-50 w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-slate-900">${{ number_format($monthRevenue, 2) }}</p>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Revenue this Month</p>
                    <p class="text-[11px] mt-1 font-medium {{ $revenueGrowth >= 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                        {{ $revenueGrowth > 0 ? '+' : '' }}{{ $revenueGrowth }}% vs last month
                    </p>
                </div>
            </div>
        </div>

        {{-- ── ROW 2: Upcoming Appointments & Low Stock ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Upcoming Appointments --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-bold text-slate-800">Upcoming Appointments</h2>
                    <a href="{{ route('modules.appointments.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">View All</a>
                </div>
                
                @if($upcomingAppointments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-6 py-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Patient</th>
                                    <th class="px-6 py-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Doctor</th>
                                    <th class="px-6 py-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Date & Time</th>
                                    <th class="px-6 py-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($upcomingAppointments as $apt)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-sm text-slate-800">{{ $apt->patient_first }} {{ $apt->patient_last }}</div>
                                            <div class="text-xs text-slate-500 truncate max-w-[150px]">{{ $apt->reason }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-sm text-slate-800">Dr. {{ $apt->doctor_last }}</div>
                                            <div class="text-xs text-slate-500">{{ $apt->specialization }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-sm text-slate-800">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('M d, Y') }}</div>
                                            <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($apt->status === 'confirmed')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Confirmed
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center flex-1 flex flex-col justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-slate-500 font-medium">No upcoming appointments found.</p>
                    </div>
                @endif
            </div>

            {{-- Low Stock Alert --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-bold text-slate-800">Low Stock Alert</h2>
                    <a href="{{ route('modules.pharmacy.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">Inventory</a>
                </div>
                
                @if($lowStockMeds->count() > 0)
                    <div class="p-4 space-y-3 flex-1 overflow-y-auto">
                        @foreach($lowStockMeds as $med)
                            <div class="flex items-center justify-between p-3 rounded-xl border {{ $med->status === 'out_of_stock' ? 'border-red-100 bg-red-50' : 'border-amber-100 bg-amber-50' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $med->status === 'out_of_stock' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold {{ $med->status === 'out_of_stock' ? 'text-red-900' : 'text-amber-900' }}">{{ $med->name }}</p>
                                        <p class="text-xs {{ $med->status === 'out_of_stock' ? 'text-red-600' : 'text-amber-600' }}">{{ $med->quantity_in_stock }} remaining</p>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wide {{ $med->status === 'out_of_stock' ? 'text-red-600' : 'text-amber-600' }}">
                                        {{ str_replace('_', ' ', $med->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center flex-1 flex flex-col justify-center">
                        <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-slate-500 font-medium">All medications are sufficiently stocked.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── ROW 3: Recent Patients ── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-800">Recently Registered Patients</h2>
                <a href="{{ route('patients.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">View All Patients</a>
            </div>
            
            @if($recentPatients->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 py-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Patient Name</th>
                                <th class="px-6 py-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Patient ID</th>
                                <th class="px-6 py-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Gender</th>
                                <th class="px-6 py-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Registered On</th>
                                <th class="px-6 py-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentPatients as $patient)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-xs font-bold text-slate-600 shrink-0">
                                                {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                            </div>
                                            <span class="font-semibold text-sm text-slate-800">{{ $patient->first_name }} {{ $patient->last_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-mono text-xs font-medium text-slate-500">{{ $patient->patient_number }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-slate-600 capitalize">{{ $patient->gender }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-slate-600">{{ \Carbon\Carbon::parse($patient->created_at)->format('M d, Y') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('patients.show', $patient->uuid) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <p class="text-slate-500 font-medium">No patients registered yet.</p>
                </div>
            @endif
        </div>

    </div>
</x-admin-layout>
