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

        /* ── Turbo smooth page transitions ──────────────── */
        @keyframes turbo-fade-in {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        #main-content {
            animation: turbo-fade-in 0.22s ease-out both;
        }
        /* Progress bar colour override */
        .turbo-progress-bar {
            height: 3px;
            background: linear-gradient(90deg, #0B5ED7, #60A5FA);
        }

        /* ── Sidebar pure CSS collapse logic ─────────────── */
        html.sidebar-is-collapsed #admin-sidebar .hide-when-collapsed { display: none !important; }
        html.sidebar-is-collapsed #admin-sidebar .show-when-collapsed { display: flex !important; }
        html:not(.sidebar-is-collapsed) #admin-sidebar .show-when-collapsed { display: none !important; }
        html.sidebar-is-collapsed #admin-sidebar .logo-container { padding-left: 0.75rem; padding-right: 0.75rem; }
        html.sidebar-is-collapsed #admin-sidebar .logo-link { width: 100%; justify-content: center; }
        html.sidebar-is-collapsed #admin-sidebar .nav-link { justify-content: center; padding-left: 0.75rem; padding-right: 0.75rem; }
    </style>
    {{ $styles ?? '' }}
    {{-- Instantly apply collapsed sidebar width from localStorage BEFORE Alpine loads --}}
    <script>
        (function() {
            var collapsed = localStorage.getItem('admin-sidebar-collapsed') === 'true';
            document.documentElement.style.setProperty('--sidebar-width', collapsed ? '96px' : '272px');
            if (collapsed) document.documentElement.classList.add('sidebar-is-collapsed');
        })();
    </script>
</head>
<body class="antialiased overflow-x-hidden">

<div class="flex min-h-screen overflow-x-hidden">

    {{-- Mobile overlay --}}
    <div x-show="$store.sidebar.open" @click="$store.sidebar.close()" x-transition.opacity
         class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden" style="display:none;"></div>

    {{-- ══ SIDEBAR ══════════════════════════════════════ --}}
    <aside
        id="admin-sidebar"
        data-turbo-permanent
        :class="[
            $store.sidebar.open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]"
        class="admin-sidebar fixed top-0 left-0 z-40 h-full flex flex-col transition-all duration-300 ease-out lg:translate-x-0 border-r border-slate-100 shadow-xl lg:shadow-none"
        style="width: var(--sidebar-width, 272px);"
    >
        {{-- Logo --}}
        <div class="logo-container px-4 flex items-center gap-3 py-4 border-b border-slate-100 flex-shrink-0 transition-all duration-300">
            <a href="{{ route('dashboard') }}" class="logo-link flex-1 flex items-center gap-3 min-w-0 transition-all duration-300">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    <x-fas-hospital class="w-5 h-5 text-white" />
                </div>
                <div class="hide-when-collapsed leading-tight min-w-0 transition-opacity">
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
                        ['label'=>'Overview',     'route'=>'dashboard',                    'active'=>'dashboard',                'permission'=>'dashboard.view',        'icon'=>'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                        ['label'=>'Patients',     'route'=>'patients.index',               'active'=>'patients.*',               'permission'=>'patients.view',         'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['label'=>'Doctors',      'route'=>'modules.doctors.index',        'active'=>'modules.doctors.*',        'permission'=>'doctors.create',        'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                        ['label'=>'Departments',  'route'=>'modules.departments.index',    'active'=>'modules.departments.*',    'permission'=>'settings.view',         'icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['label'=>'Laboratory',   'route'=>'modules.laboratory.index',     'active'=>'modules.laboratory.*',     'permission'=>'laboratory.view',       'icon'=>'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                        ['label'=>'Blog / CMS',   'route'=>'modules.cms.index',            'active'=>'modules.cms.*',            'permissions'=>['cms.create','cms.approve'], 'icon'=>'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                        ['label'=>'Appointments', 'route'=>'modules.appointments.index',   'active'=>'modules.appointments.*',   'permission'=>'appointments.view',     'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['label'=>'Pharmacy',     'route'=>'modules.pharmacy.index',       'active'=>'modules.pharmacy.*',       'permission'=>'pharmacy.view',         'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ['label'=>'Billing',      'route'=>'modules.billing.index',        'active'=>'modules.billing.*',        'permission'=>'billing.view',          'icon'=>'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z'],
                    ],
                    'SYSTEM' => [
                        ['label'=>'User Management', 'route'=>'admin.users.index',              'active'=>'admin.users.*',              'permission'=>'users.view',        'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['label'=>'Reports',         'route'=>'modules.reports.index',          'active'=>'modules.reports.*',          'permission'=>'reports.view',      'icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['label'=>'Notice',          'route'=>'modules.notifications.index',    'active'=>'modules.notifications.*',    'permission'=>'dashboard.view',    'icon'=>'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                        ['label'=>'Settings',        'route'=>'modules.settings.index',         'active'=>'modules.settings.*',         'permission'=>'settings.view',     'icon'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                    ],
                ];
            @endphp

            @foreach($navGroups as $groupLabel => $items)
                @php
                    // Filter by permission — supports single 'permission' key or multi-OR 'permissions' array
                    $visibleItems = collect($items)->filter(function($item) {
                        $user = auth()->user();
                        if (!$user) return false;
                        if ($user->id === 1 || $user->hasRole('Super Admin')) return true;
                        $perms = $item['permissions'] ?? [$item['permission'] ?? 'dashboard.view'];
                        foreach ($perms as $perm) {
                            if ($user->can($perm)) return true;
                        }
                        return false;
                    });
                @endphp
                @if($visibleItems->isNotEmpty())
                <div class="{{ $loop->first ? '' : 'pt-3' }}">
                    <p class="hide-when-collapsed admin-sidebar-heading px-4 mb-1.5 font-bold text-slate-400 uppercase">{{ $groupLabel }}</p>
                    @foreach($visibleItems as $item)
                        @php $isActive = request()->routeIs($item['active']); @endphp
                        <a href="{{ route($item['route']) }}"
                           title="{{ $item['label'] }}"
                           class="nav-link admin-sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 mb-0.5 {{ $isActive ? 'nav-item-active' : 'nav-item-inactive' }}">
                            <svg class="admin-sidebar-icon flex-shrink-0 {{ $isActive ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                            <span class="hide-when-collapsed flex-1 leading-none truncate">{{ $item['label'] }}</span>
                            @if(!empty($item['badge']))
                                <span class="hide-when-collapsed text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ $isActive ? 'bg-white/25 text-white' : 'bg-blue-100 text-blue-600' }}">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
                @endif
            @endforeach
        </nav>

        </div>
    </aside>

    <div
        id="sidebar-spacer"
        data-turbo-permanent
        aria-hidden="true"
        class="hidden lg:block flex-shrink-0 transition-all duration-300"
        style="width: var(--sidebar-width, 272px);"
    ></div>

    {{-- ══ MAIN ══════════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-[3px]">

        {{-- Header --}}
        <header class="bg-white border-b border-slate-100 pl-4 pr-6 py-3.5 flex items-center gap-4 flex-shrink-0 z-20 shadow-sm">
            <button @click="$store.sidebar.open = !$store.sidebar.open" class="lg:hidden w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-100 hover:text-blue-600 transition-colors">
                <x-fas-bars class="w-5 h-5" />
            </button>
            <button @click="$store.sidebar.toggle()" type="button" class="hidden lg:flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-colors hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">
                <x-fas-bars class="w-4 h-4 transition-transform duration-200" />
            </button>
            <div class="flex-1 max-w-sm relative lg:ml-1">
                <x-fas-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                <input type="search" placeholder="Search patients, doctors, reports…" class="w-full pl-9 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 text-slate-700">
            </div>
            <div class="flex items-center gap-2.5 ml-auto">
                <a href="{{ route('modules.notifications.index') }}" class="relative w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-colors">
                    <x-fas-bell class="w-[18px] h-[18px]" />
                    @auth
                        @php
                            $unreadCount = auth()->user()->unreadNotifications()->count();
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
                        <x-fas-chevron-down class="w-4 h-4 text-slate-400 transition-transform" />
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
        <main id="main-content" class="flex-1 py-6 px-6 lg:px-10 xl:px-12">
            {{ $slot }}
        </main>
    </div>
</div>

{{-- ── Turbo: update active sidebar link on every navigation ── --}}
<script>
    function updateActiveSidebarLink() {
        const current = window.location.pathname;
        document.querySelectorAll('#admin-sidebar a.admin-sidebar-link').forEach(link => {
            const href = new URL(link.href, window.location.origin).pathname;
            // Match exact or sub-path (e.g. /dashboard/patients matches /dashboard/patients/*)
            // But skip prefix matching for /dashboard or / so they are only active on exact match
            const isActive = current === href || (href !== '/dashboard' && href !== '/' && current.startsWith(href));
            link.classList.toggle('nav-item-active', isActive);
            link.classList.toggle('nav-item-inactive', !isActive);
            // Sync SVG colour
            const svg = link.querySelector('svg');
            if (svg) svg.classList.toggle('text-white', isActive);
        });
    }
    // Run on initial load
    document.addEventListener('DOMContentLoaded', updateActiveSidebarLink);
    // Run on every Turbo navigation
    document.addEventListener('turbo:load', updateActiveSidebarLink);
</script>

</body>
</html>
