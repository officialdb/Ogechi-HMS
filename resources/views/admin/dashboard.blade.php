<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard – Ogechi HMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background: #F1F5F9; }

        /* Sidebar active pill */
        .nav-item-active {
            background: linear-gradient(135deg, #0B5ED7, #1D4ED8);
            color: #fff !important;
            box-shadow: 0 4px 16px rgba(11,94,215,0.35);
        }
        .nav-item-active svg { color: #fff !important; }

        .nav-item-inactive {
            color: #64748B;
        }
        .nav-item-inactive:hover {
            background: #EFF6FF;
            color: #0B5ED7;
        }
        .nav-item-inactive:hover svg { color: #0B5ED7; }
        .admin-sidebar { background: rgba(255,255,255,0.98); }
        .admin-sidebar-link { min-height: 48px; }
        .admin-sidebar-icon { width: 20px; height: 20px; min-width: 20px; min-height: 20px; }
        .admin-sidebar-heading { font-size: 10px; letter-spacing: .16em; }
        [x-cloak] { display: none !important; }

        /* Progress bar fill animation */
        .progress-fill {
            height: 100%;
            border-radius: 99px;
            animation: growBar .8s ease forwards;
        }
        @keyframes growBar {
            from { width: 0 !important; }
            to   { /* width set inline */ }
        }

        /* Skeleton shimmer */
        @keyframes shimmer {
            0%   { background-position: -600px 0; }
            100% { background-position: 600px 0; }
        }
        .skeleton {
            background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
            background-size: 600px 100%;
            animation: shimmer 1.6s infinite linear;
            border-radius: 10px;
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">

<div
    x-data="{
        sidebarOpen: false,
        sidebarCollapsed: false,
        loading: true,
        init() {
            this.sidebarCollapsed = localStorage.getItem('admin-sidebar-collapsed') === 'true';
            setTimeout(() => this.loading = false, 1800)
        },
        toggleSidebarCollapse() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('admin-sidebar-collapsed', this.sidebarCollapsed ? 'true' : 'false');
        }
    }"
    class="flex min-h-screen overflow-x-hidden"
>

    {{-- ══════════════════════════════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════════════════════════════ --}}

    {{-- Mobile backdrop --}}
    <div x-show="sidebarOpen" @click="sidebarOpen=false"
         x-transition.opacity
         class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden"
         style="display:none;"></div>

    <aside
        :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]"
        class="admin-sidebar fixed top-0 left-0 z-40 h-full w-[272px] flex flex-col
               transition-all duration-300 ease-out
               lg:translate-x-0
               border-r border-slate-100 shadow-xl lg:shadow-none"
        :style="{ width: sidebarCollapsed ? '96px' : '272px' }"
    >
        {{-- Logo --}}
        <div :class="sidebarCollapsed ? 'px-3' : 'px-4'" class="flex items-center gap-3 py-4 border-b border-slate-100 flex-shrink-0 transition-all duration-300">
            <a href="{{ route('dashboard') }}"
               :class="sidebarCollapsed ? 'w-full justify-center' : 'flex-1'"
               class="flex items-center gap-3 min-w-0 transition-all duration-300">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md"
                     style="background: linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="leading-tight min-w-0" x-cloak x-show="!sidebarCollapsed" x-transition.opacity>
                    <p class="text-sm font-bold text-slate-900 truncate">Ogechi HMS</p>
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.14em] truncate">Hospital Management</p>
                </div>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto py-4">
        {{-- Navigation --}}
        <nav class="px-3 space-y-0.5">

            @php
                $navGroups = [
                    'MAIN' => [
                        ['label'=>'Overview',     'route'=>'dashboard',    'active'=>'dashboard',     'icon'=>'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                        ['label'=>'Patients',     'route'=>'patients.index','active'=>'patients.*',   'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['label'=>'Doctors',      'route'=>'modules.doctors.index','active'=>'modules.doctors.*','icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                        ['label'=>'Blog / CMS',   'route'=>'modules.cms.index','active'=>'modules.cms.*','icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['label'=>'Appointments', 'route'=>'modules.appointments.index','active'=>'modules.appointments.*','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','badge'=>'5'],
                        ['label'=>'Pharmacy',     'route'=>'modules.pharmacy.index','active'=>'modules.pharmacy.*','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ['label'=>'Billing',      'route'=>'modules.billing.index','active'=>'modules.billing.*','icon'=>'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z'],
                    ],
                    'SYSTEM' => [
                        ['label'=>'Reports',  'route'=>'modules.reports.index','active'=>'modules.reports.*','icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['label'=>'Notice',   'route'=>'modules.notifications.index','active'=>'modules.notifications.*','icon'=>'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                        ['label'=>'Settings', 'route'=>'modules.settings.index','active'=>'modules.settings.*','icon'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                    ],
                ];
            @endphp

            @foreach($navGroups as $groupLabel => $items)
                <div class="{{ $loop->first ? '' : 'pt-3' }}">
                    <p x-cloak x-show="!sidebarCollapsed" class="admin-sidebar-heading px-4 mb-1.5 font-bold text-slate-400 uppercase">
                        {{ $groupLabel }}
                    </p>
                    @foreach($items as $item)
                        @php $isActive = request()->routeIs($item['active']); @endphp
                        <a href="{{ route($item['route']) }}"
                           :class="sidebarCollapsed ? 'justify-center px-3' : ''"
                           title="{{ $item['label'] }}"
                           class="admin-sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 mb-0.5
                                  {{ $isActive ? 'nav-item-active' : 'nav-item-inactive' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="admin-sidebar-icon flex-shrink-0 {{ $isActive ? 'text-white' : 'text-slate-400' }}"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                            </svg>
                            <span x-cloak x-show="!sidebarCollapsed" class="flex-1 leading-none truncate">{{ $item['label'] }}</span>
                            @if(!empty($item['badge']))
                                <span x-cloak x-show="!sidebarCollapsed" class="text-[10px] font-bold px-1.5 py-0.5 rounded-full
                                             {{ $isActive ? 'bg-white/25 text-white' : 'bg-blue-100 text-blue-600' }}">
                                    {{ $item['badge'] }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
        </nav>

        {{-- Create New card --}}
        <div x-cloak x-show="!sidebarCollapsed" x-transition.opacity class="m-3 mt-4 rounded-2xl p-4 overflow-hidden"
             style="background: linear-gradient(135deg,#EFF6FF 0%,#DBEAFE 100%); border: 1px solid #BFDBFE;">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center mx-auto mb-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div x-cloak x-show="!sidebarCollapsed" x-transition.opacity>
                <p class="text-[11px] font-bold text-slate-700 text-center mb-0.5">Add New Category</p>
                <p class="text-[10px] text-slate-400 text-center mb-3">or Database</p>
            </div>
            <a href="{{ route('patients.create') }}"
               :class="sidebarCollapsed ? 'text-[0px] py-2.5' : 'text-xs py-2'"
               class="block w-full text-center text-white font-bold rounded-xl transition-all duration-200 hover:opacity-90 hover:shadow-md overflow-hidden"
               style="background: linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                + Create New
            </a>
        </div>
        <a x-cloak x-show="sidebarCollapsed" x-transition.opacity href="{{ route('patients.create') }}" title="Create New" class="mx-auto mt-4 mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-md transition-all duration-200 hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
        </a>
        </div>
    </aside>

    <div
        aria-hidden="true"
        class="hidden lg:block flex-shrink-0 transition-all duration-300"
        :style="{ width: sidebarCollapsed ? '96px' : '272px' }"
    ></div>

    {{-- ══════════════════════════════════════════════════════════════
         MAIN AREA
    ══════════════════════════════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-[3px]">

        {{-- TOP HEADER --}}
        <header class="bg-white border-b border-slate-100 pl-4 pr-6 py-3.5 flex items-center gap-4 flex-shrink-0 z-20 shadow-sm">
            <button @click="sidebarOpen=!sidebarOpen"
                    class="lg:hidden w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-100 hover:text-blue-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <button @click="toggleSidebarCollapse()" type="button"
                    class="hidden lg:flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-colors hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <div class="flex-1 max-w-sm relative lg:ml-1">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="search"
                       placeholder="Search for Files, Patient or Files"
                       class="w-full pl-9 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                              transition-colors placeholder-slate-400 text-slate-700">
            </div>

            <div class="flex items-center gap-2.5 ml-auto">
                {{-- Notification --}}
                <button class="relative w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center
                               text-slate-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center shadow-sm">3</span>
                </button>

                {{-- User --}}
                <div class="flex items-center gap-2.5 pl-3 border-l border-slate-100 cursor-pointer">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0"
                         style="background: linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <p class="text-[13px] font-semibold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Admin</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </header>

        {{-- SCROLLABLE CONTENT --}}
        <main class="flex-1 overflow-y-auto py-6 px-6 lg:px-10 xl:px-12 space-y-6">

            {{-- ██████████████████████████████████████████████
                 SKELETON LOADER  (shows for 1.8 s on load)
            ██████████████████████████████████████████████ --}}
            <div x-show="loading" x-transition.opacity class="space-y-5">
                {{-- Heading skeleton --}}
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <div class="skeleton h-6 w-56"></div>
                        <div class="skeleton h-4 w-80"></div>
                    </div>
                    <div class="skeleton h-9 w-36 rounded-xl hidden sm:block"></div>
                </div>

                {{-- Stat cards skeleton --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @for($i=0;$i<4;$i++)
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 flex items-center gap-4">
                            <div class="skeleton w-14 h-14 rounded-2xl flex-shrink-0"></div>
                            <div class="space-y-2 flex-1">
                                <div class="skeleton h-7 w-20"></div>
                                <div class="skeleton h-3 w-24"></div>
                                <div class="skeleton h-3 w-16"></div>
                            </div>
                        </div>
                    @endfor
                </div>

                {{-- Row 2 skeleton --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                    @for($i=0;$i<3;$i++)
                        <div class="bg-white rounded-2xl p-6 border border-slate-100 space-y-4">
                            <div class="flex justify-between">
                                <div class="skeleton h-4 w-36"></div>
                                <div class="skeleton h-4 w-16 rounded-lg"></div>
                            </div>
                            <div class="skeleton w-36 h-36 rounded-full mx-auto"></div>
                            <div class="space-y-2.5">
                                @for($j=0;$j<4;$j++)
                                    <div class="flex gap-2">
                                        <div class="skeleton h-3 flex-1"></div>
                                        <div class="skeleton h-3 w-8 rounded-full"></div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endfor
                </div>

                {{-- Row 3 skeleton --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 overflow-hidden">
                        <div class="flex justify-between px-6 pt-5 pb-4 border-b border-slate-100">
                            <div class="skeleton h-4 w-40"></div>
                            <div class="skeleton h-4 w-14"></div>
                        </div>
                        @for($i=0;$i<5;$i++)
                            <div class="flex items-center gap-4 px-6 py-3.5 border-b border-slate-50">
                                <div class="skeleton w-6 h-4 rounded"></div>
                                <div class="skeleton w-7 h-7 rounded-lg"></div>
                                <div class="skeleton h-3 flex-1"></div>
                                <div class="skeleton h-3 w-20"></div>
                                <div class="skeleton h-6 w-12 rounded-lg"></div>
                            </div>
                        @endfor
                    </div>
                    <div class="bg-white rounded-2xl p-6 border border-slate-100 space-y-3">
                        <div class="skeleton h-4 w-28"></div>
                        @for($i=0;$i<5;$i++)
                            <div class="flex items-center gap-3 p-2">
                                <div class="skeleton w-10 h-10 rounded-xl flex-shrink-0"></div>
                                <div class="flex-1 space-y-1.5">
                                    <div class="skeleton h-3 w-24"></div>
                                    <div class="skeleton h-2.5 w-16"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- ██████████████████████████████████████████████
                 ACTUAL DASHBOARD CONTENT
            ██████████████████████████████████████████████ --}}
            <div x-show="!loading" x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-5" style="display:none;">

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
                    @php
                        $statCards = [
                            ['label'=>'Total Doctors',  'value'=>'2,937','delta'=>'+3 this week',  'color'=>'text-blue-600',  'bg'=>'bg-blue-50',  'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','up'=>true],
                            ['label'=>'Total Staff',    'value'=>'5,453','delta'=>'8 on vacation',  'color'=>'text-amber-500', 'bg'=>'bg-amber-50', 'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','up'=>false],
                            ['label'=>'Total Patients', 'value'=>'170K', 'delta'=>'+175 admitted',  'color'=>'text-rose-500',  'bg'=>'bg-rose-50',  'icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','up'=>true],
                            ['label'=>'Pharmacies',     'value'=>'21',   'delta'=>'85k on reserve', 'color'=>'text-sky-500',   'bg'=>'bg-sky-50',   'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','up'=>false],
                        ];
                    @endphp
                    @foreach($statCards as $card)
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-4">
                            <div class="{{ $card['bg'] }} w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 {{ $card['color'] }}"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-slate-900">{{ $card['value'] }}</p>
                                <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $card['label'] }}</p>
                                <p class="text-[11px] mt-1 font-medium {{ $card['up'] ? 'text-emerald-600' : 'text-slate-400' }}">
                                    {{ $card['delta'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ── ROW 2: Donut + Report + Stats ── --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                    {{-- Donut Chart --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-sm font-bold text-slate-800">Birth & Death Analytics</h2>
                            <select class="text-xs border border-slate-200 rounded-lg px-2 py-1 text-slate-500 focus:outline-none bg-slate-50">
                                <option>May 2026</option><option>Apr 2026</option>
                            </select>
                        </div>
                        <div class="flex justify-center my-1">
                            <div class="relative w-40 h-40">
                                <svg viewBox="0 0 100 100" class="w-full h-full" style="transform:rotate(-90deg)">
                                    <circle cx="50" cy="50" r="36" fill="none" stroke="#EFF6FF" stroke-width="13"/>
                                    <circle cx="50" cy="50" r="36" fill="none" stroke="#0B5ED7" stroke-width="13"
                                            stroke-dasharray="101.8 124.4" stroke-linecap="round"/>
                                    <circle cx="50" cy="50" r="36" fill="none" stroke="#F59E0B" stroke-width="13"
                                            stroke-dasharray="41.6 184.6" stroke-dashoffset="-101.8" stroke-linecap="round"/>
                                    <circle cx="50" cy="50" r="36" fill="none" stroke="#EF4444" stroke-width="13"
                                            stroke-dasharray="65.6 160.6" stroke-dashoffset="-143.4" stroke-linecap="round"/>
                                    <circle cx="50" cy="50" r="36" fill="none" stroke="#E2E8F0" stroke-width="13"
                                            stroke-dasharray="17.6 208.6" stroke-dashoffset="-209.0" stroke-linecap="round"/>
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <p class="text-xl font-black text-slate-900">92.5%</p>
                                    <p class="text-[10px] text-slate-400 font-medium">Success</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-around mt-4 pt-4 border-t border-slate-50">
                            @foreach([['#0B5ED7','Birth Case','45.07%'],['#F59E0B','Accident','18.43%'],['#EF4444','Death Case','29.05%']] as $leg)
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-1 mb-1">
                                        <div class="w-2 h-2 rounded-full" style="background:{{ $leg[0] }}"></div>
                                        <span class="text-[10px] text-slate-400 font-medium">{{ $leg[1] }}</span>
                                    </div>
                                    <p class="text-xs font-bold text-slate-700">{{ $leg[2] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Hospital Reports --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-sm font-bold text-slate-800">Hospital Report</h2>
                            <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">View All</a>
                        </div>
                        <div class="space-y-2">
                            @foreach([
                                ['bg'=>'bg-blue-50','tc'=>'text-blue-600','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','title'=>'Room 501 AC is not working','sub'=>'Reported by Steve','badge'=>'Urgent','bc'=>'bg-red-100 text-red-600'],
                                ['bg'=>'bg-amber-50','tc'=>'text-amber-500','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','title'=>'Daniel extended his holiday','sub'=>'Reported by Andrew','badge'=>'Pending','bc'=>'bg-amber-100 text-amber-600'],
                                ['bg'=>'bg-teal-50','tc'=>'text-teal-600','icon'=>'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16','title'=>'101 washroom needed to clean','sub'=>'Reported by Steve','badge'=>'Review','bc'=>'bg-teal-100 text-teal-700'],
                            ] as $r)
                                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                                    <div class="{{ $r['bg'] }} {{ $r['tc'] }} w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $r['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-800 leading-snug">{{ $r['title'] }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $r['sub'] }}</p>
                                    </div>
                                    <span class="{{ $r['bc'] }} text-[10px] font-bold px-2 py-0.5 rounded-lg flex-shrink-0">{{ $r['badge'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Success Stats --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-sm font-bold text-slate-800">Success Stats</h2>
                            <select class="text-xs border border-slate-200 rounded-lg px-2 py-1 text-slate-500 focus:outline-none bg-slate-50">
                                <option>May 2026</option>
                            </select>
                        </div>
                        <div class="space-y-4">
                            @foreach([
                                ['label'=>'Anesthetics','val'=>83, 'color'=>'#0B5ED7'],
                                ['label'=>'Gynecology', 'val'=>95, 'color'=>'#0B5ED7'],
                                ['label'=>'Nerology',   'val'=>100,'color'=>'#10B981'],
                                ['label'=>'Oncology',   'val'=>89, 'color'=>'#0B5ED7'],
                                ['label'=>'Orthopedics','val'=>97, 'color'=>'#0B5ED7'],
                                ['label'=>'Physiotherapy','val'=>100,'color'=>'#10B981'],
                            ] as $s)
                                <div class="flex items-center gap-3">
                                    <p class="text-xs font-medium text-slate-500 w-[90px] flex-shrink-0">{{ $s['label'] }}</p>
                                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full progress-fill"
                                             style="width:{{ $s['val'] }}%; background:{{ $s['color'] }};"></div>
                                    </div>
                                    <p class="text-xs font-bold text-slate-700 w-8 text-right">{{ $s['val'] }}%</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ── ROW 3: Appointments + Doctors List ── --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                    {{-- Appointments Table --}}
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-slate-100">
                            <h2 class="text-sm font-bold text-slate-800">Online Appointment</h2>
                            <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-slate-50/80">
                                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">No.</th>
                                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Date & Time</th>
                                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Age</th>
                                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Gender</th>
                                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Appoint for</th>
                                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Setting</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach([
                                        ['01','Cameron','20 May 6:30pm',54,'Male',  'Dr. Lee'],
                                        ['02','Jorge',  '20 May 7:30pm',76,'Female','Dr. Gregory'],
                                        ['03','Philip', '20 May 8:30pm',47,'Male',  'Dr. Bernard'],
                                        ['04','Nathan', '20 May 9:00pm',40,'Female','Dr. Mitchell'],
                                        ['05','Soham',  '20 May 6:30pm',43,'Female','Dr. Randall'],
                                    ] as [$no,$name,$date,$age,$gender,$doc])
                                        <tr class="hover:bg-blue-50/20 transition-colors group">
                                            <td class="px-6 py-3 text-xs font-bold text-slate-400">{{ $no }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold">{{ substr($name,0,1) }}</div>
                                                    <span class="text-xs font-semibold text-slate-800">{{ $name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-xs text-slate-600">{{ $date }}</td>
                                            <td class="px-4 py-3 text-xs text-slate-600">{{ $age }}</td>
                                            <td class="px-4 py-3">
                                                <span class="text-[11px] px-2 py-0.5 rounded-lg font-semibold
                                                             {{ $gender==='Male' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                                    {{ $gender }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-xs font-medium text-slate-700">{{ $doc }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex gap-1.5 opacity-40 group-hover:opacity-100 transition-opacity">
                                                    <button class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white flex items-center justify-center transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    </button>
                                                    <button class="w-7 h-7 rounded-lg bg-red-50 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Doctors List --}}
                    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-sm font-bold text-slate-800">Doctors List</h2>
                            <a href="{{ route('website.doctors') }}"
                               class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                        <div class="space-y-1">
                            @foreach([
                                ['Dr. Brandon','Gynecologist',     'from-pink-400 to-rose-500'],
                                ['Dr. Gregory','Cardiologist',      'from-blue-400 to-blue-600'],
                                ['Dr. Robert', 'Orthopedicologist', 'from-teal-400 to-teal-600'],
                                ['Dr. Calvin', 'Neurologist',       'from-violet-400 to-purple-600'],
                            ] as [$name,$spec,$grad])
                                <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors group">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $grad }} text-white font-bold text-sm flex items-center justify-center shadow-sm flex-shrink-0">
                                        {{ substr($name,3,1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-slate-800 truncate">{{ $name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $spec }}</p>
                                    </div>
                                    <button class="w-6 h-6 rounded-lg text-slate-300 hover:text-slate-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>{{-- end !loading --}}
        </main>
    </div>
</div>

</body>
</html>
