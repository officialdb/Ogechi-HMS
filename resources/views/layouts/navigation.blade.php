@php
    $links = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => 'dashboard', 'description' => 'Overview and deployment status'],
        ['label' => 'Patients', 'route' => 'patients.index', 'active' => 'patients.*', 'description' => 'Registration, history, and records'],
        ['label' => 'Profile', 'route' => 'profile.edit', 'active' => 'profile.*', 'description' => 'Account settings and security'],
    ];

    $plannedModules = ['Patients', 'Appointments', 'Doctors', 'Billing', 'CMS'];
    $userRoles = Auth::user()?->getRoleNames()->join(', ') ?: 'No role assigned';
@endphp

<nav x-data="{ open: false }">
    <div class="flex items-center justify-between px-4 py-4 lg:hidden">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="h-11 w-11" />
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.28em] text-teal-700">Ogechi HMS</p>
                <p class="text-xs text-slate-500">Admin workspace</p>
            </div>
        </a>

        <button
            type="button"
            @click="open = !open"
            class="rounded-full border border-slate-300 bg-white/80 p-3 text-slate-700"
        >
            <x-fas-eye class="h-5 w-5" />
        </button>
    </div>

    <aside
        :class="{ 'translate-x-0 opacity-100': open, '-translate-x-full opacity-0 lg:translate-x-0 lg:opacity-100': !open }"
        class="fixed inset-y-0 left-0 z-40 w-80 transform transition duration-300 ease-out lg:translate-x-0 lg:opacity-100"
    >
        <div class="m-4 flex h-[calc(100%-2rem)] flex-col overflow-hidden rounded-[2rem] border border-white/70 bg-slate-950 text-white shadow-2xl shadow-slate-900/20">
            <div class="bg-[radial-gradient(circle_at_top_left,_rgba(45,212,191,0.35),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(251,191,36,0.18),_transparent_24%)] px-6 py-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4">
                    <x-application-logo class="h-14 w-14" />
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-teal-200">Ogechi HMS</p>
                        <h1 class="mt-1 text-xl font-semibold">Hospital Management System</h1>
                    </div>
                </a>

                <div class="mt-6 rounded-[1.5rem] border border-white/10 bg-white/10 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-[0.24em] text-teal-200">Signed in as</p>
                    <p class="mt-2 text-lg font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-slate-300">{{ Auth::user()->email }}</p>
                    <p class="mt-3 text-xs uppercase tracking-[0.22em] text-amber-200">{{ $userRoles }}</p>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-5">
                <div class="space-y-2">
                    @foreach ($links as $link)
                        <a
                            href="{{ route($link['route']) }}"
                            class="{{ request()->routeIs($link['active']) ? 'bg-white text-slate-950 shadow-lg shadow-slate-900/10' : 'text-slate-200 hover:bg-white/10 hover:text-white' }} block rounded-[1.35rem] px-4 py-4 transition"
                        >
                            <span class="block text-sm font-semibold uppercase tracking-[0.2em]">{{ $link['label'] }}</span>
                            <span class="mt-1 block text-sm {{ request()->routeIs($link['active']) ? 'text-slate-600' : 'text-slate-400' }}">{{ $link['description'] }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    <p class="px-3 text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Next modules</p>
                    <div class="mt-3 space-y-2">
                        @foreach ($plannedModules as $module)
                            <div class="rounded-[1.25rem] border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">
                                {{ $module }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 px-5 py-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-full bg-white/10 px-4 py-3 text-sm font-semibold uppercase tracking-[0.22em] text-white transition hover:bg-white/20">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 z-30 bg-slate-950/50 lg:hidden"
    ></div>
</nav>
