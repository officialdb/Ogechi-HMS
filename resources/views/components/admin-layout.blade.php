<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} – Ogechi HMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background: #F1F5F9; }
        .nav-item-active { background: linear-gradient(135deg,#0B5ED7,#1D4ED8); color:#fff !important; box-shadow:0 4px 16px rgba(11,94,215,0.35); }
        .nav-item-active svg { color:#fff !important; }
        .nav-item-inactive { color:#64748B; }
        .nav-item-inactive:hover { background:#EFF6FF; color:#0B5ED7; }
        .nav-item-inactive:hover svg { color:#0B5ED7; }
        .admin-sidebar { background: rgba(255,255,255,0.98); }
        .admin-sidebar-link { min-height: 48px; }
        .admin-sidebar-icon { width: 20px; height: 20px; min-width: 20px; min-height: 20px; }
        .admin-sidebar-heading { font-size: 10px; letter-spacing: .16em; }
        [x-cloak] { display: none !important; }
        @keyframes shimmer { 0%{background-position:-600px 0} 100%{background-position:600px 0} }
        .skeleton { background:linear-gradient(90deg,#e2e8f0 25%,#f1f5f9 50%,#e2e8f0 75%); background-size:600px 100%; animation:shimmer 1.6s infinite linear; border-radius:10px; }
    </style>
    {{ $styles ?? '' }}
</head>
<body class="antialiased overflow-x-hidden">

<div class="flex min-h-screen overflow-x-hidden" x-data="{
    sidebarOpen: false,
    sidebarCollapsed: false,
    init() {
        this.sidebarCollapsed = localStorage.getItem('admin-sidebar-collapsed') === 'true';
    },
    toggleSidebarCollapse() {
        this.sidebarCollapsed = !this.sidebarCollapsed;
        localStorage.setItem('admin-sidebar-collapsed', this.sidebarCollapsed ? 'true' : 'false');
    }
}">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen=false" x-transition.opacity
         class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden" style="display:none;"></div>

    {{-- ══ SIDEBAR ══════════════════════════════════════ --}}
    <aside
        :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]"
        class="admin-sidebar fixed top-0 left-0 z-40 h-full w-[272px] flex flex-col transition-all duration-300 ease-out lg:translate-x-0 border-r border-slate-100 shadow-xl lg:shadow-none"
        :style="{ width: sidebarCollapsed ? '96px' : '272px' }"
    >
        {{-- Logo --}}
        <div :class="sidebarCollapsed ? 'px-3' : 'px-4'" class="flex items-center gap-3 py-4 border-b border-slate-100 flex-shrink-0 transition-all duration-300">
            <a href="{{ route('dashboard') }}" :class="sidebarCollapsed ? 'w-full justify-center' : 'flex-1'" class="flex items-center gap-3 min-w-0 transition-all duration-300">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="leading-tight min-w-0" x-show="!sidebarCollapsed" x-transition.opacity>
                    <p class="text-sm font-bold text-slate-900 truncate">Ogechi HMS</p>
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.14em] truncate">Hospital Management</p>
                </div>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto py-4">
        {{-- Nav --}}
        <nav class="px-3 space-y-0.5">
            @php
                $navGroups = [
                    'MAIN' => [
                        ['label'=>'Overview',     'route'=>'dashboard',       'active'=>'dashboard',       'icon'=>'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                        ['label'=>'Patients',     'route'=>'patients.index',  'active'=>'patients.*',      'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['label'=>'Doctors',      'route'=>'modules.doctors.index',      'active'=>'modules.doctors.*',      'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                        ['label'=>'Departments',  'route'=>'modules.departments.index',  'active'=>'modules.departments.*',  'icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['label'=>'Laboratory',   'route'=>'modules.laboratory.index',   'active'=>'modules.laboratory.*',   'icon'=>'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                        ['label'=>'Blog / CMS',   'route'=>'modules.cms.index',          'active'=>'modules.cms.*',          'icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['label'=>'Appointments', 'route'=>'modules.appointments.index', 'active'=>'modules.appointments.*', 'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','badge'=>'5'],
                        ['label'=>'Pharmacy',     'route'=>'modules.pharmacy.index',     'active'=>'modules.pharmacy.*',     'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ['label'=>'Billing',      'route'=>'modules.billing.index',      'active'=>'modules.billing.*',      'icon'=>'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z'],
                    ],
                    'SYSTEM' => [
                        ['label'=>'Reports',  'route'=>'modules.reports.index',       'active'=>'modules.reports.*',       'icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['label'=>'Notice',   'route'=>'modules.notifications.index', 'active'=>'modules.notifications.*', 'icon'=>'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                        ['label'=>'Settings', 'route'=>'modules.settings.index',      'active'=>'modules.settings.*',      'icon'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                    ],
                ];
            @endphp

            @foreach($navGroups as $groupLabel => $items)
                <div class="{{ $loop->first ? '' : 'pt-3' }}">
                    <p x-cloak x-show="!sidebarCollapsed" class="admin-sidebar-heading px-4 mb-1.5 font-bold text-slate-400 uppercase">{{ $groupLabel }}</p>
                    @foreach($items as $item)
                        @php $isActive = request()->routeIs($item['active']); @endphp
                        <a href="{{ route($item['route']) }}"
                           :class="sidebarCollapsed ? 'justify-center px-3' : ''"
                           title="{{ $item['label'] }}"
                           class="admin-sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 mb-0.5 {{ $isActive ? 'nav-item-active' : 'nav-item-inactive' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="admin-sidebar-icon flex-shrink-0 {{ $isActive ? 'text-white' : 'text-slate-400' }}"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                            </svg>
                            <span x-cloak x-show="!sidebarCollapsed" class="flex-1 leading-none truncate">{{ $item['label'] }}</span>
                            @if(!empty($item['badge']))
                                <span x-cloak x-show="!sidebarCollapsed" class="text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ $isActive ? 'bg-white/25 text-white' : 'bg-blue-100 text-blue-600' }}">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
        </nav>

        {{-- Create New --}}
        <div x-cloak x-show="!sidebarCollapsed" x-transition.opacity class="m-3 mt-4 rounded-2xl p-4 overflow-hidden" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);border:1px solid #BFDBFE;">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center mx-auto mb-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div x-cloak x-show="!sidebarCollapsed" x-transition.opacity>
                <p class="text-[11px] font-bold text-slate-700 text-center mb-0.5">Add New Category</p>
                <p class="text-[10px] text-slate-400 text-center mb-3">or Database</p>
            </div>
            <a href="{{ route('patients.create') }}" :class="sidebarCollapsed ? 'text-[0px] py-2.5' : 'text-xs py-2'" class="block w-full text-center text-white font-bold rounded-xl transition-all duration-200 hover:opacity-90 shadow-md overflow-hidden" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
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

    {{-- ══ MAIN ══════════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-[3px]">

        {{-- Header --}}
        <header class="bg-white border-b border-slate-100 pl-4 pr-6 py-3.5 flex items-center gap-4 flex-shrink-0 z-20 shadow-sm">
            <button @click="sidebarOpen=!sidebarOpen" class="lg:hidden w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-100 hover:text-blue-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <button @click="toggleSidebarCollapse()" type="button" class="hidden lg:flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-colors hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <div class="flex-1 max-w-sm relative lg:ml-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="search" placeholder="Search patients, doctors, reports…" class="w-full pl-9 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 text-slate-700">
            </div>
            <div class="flex items-center gap-2.5 ml-auto">
                <a href="{{ route('modules.notifications.index') }}" class="relative w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @auth
                        @php
                            $unreadCount = \Illuminate\Support\Facades\Cache::remember(
                                'unread_notifications_' . auth()->id(),
                                60,
                                fn() => auth()->user()->unreadNotifications()->count()
                            );
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center shadow-sm">{{ $unreadCount }}</span>
                        @endif
                    @endauth
                </a>
                <div class="relative" x-data="{ userMenuOpen: false }" @click.away="userMenuOpen = false">
                    <div @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2.5 pl-3 border-l border-slate-100 cursor-pointer">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="hidden sm:block leading-tight">
                            <p class="text-[13px] font-semibold text-slate-800 leading-none">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Administrator</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 transition-transform" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>

                    {{-- Dropdown Menu --}}
                    <div x-cloak x-show="userMenuOpen" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50">
                        
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                            Admin Profile
                        </a>
                        
                        <div class="border-t border-slate-100 my-1"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 py-6 px-6 lg:px-10 xl:px-12">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
