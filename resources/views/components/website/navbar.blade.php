{{-- Main Navigation --}}
<nav
    id="main-navbar"
    x-data="{ open: false }"
    class="sticky top-0 z-50 transition-all duration-300 bg-white border-b border-gray-100"
    :class="{ 'shadow-lg shadow-blue-900/10 bg-white/95 backdrop-blur-md': $scroll('y') > 80 }"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Mobile Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 lg:hidden">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900 text-base">Ogechi Hospital</span>
            </a>

            {{-- Desktop Navigation Pill --}}
            <div class="hidden lg:flex items-center gap-1 bg-blue-600 rounded-full px-2 py-1.5">
                @php
                    $navItems = [
                        ['label' => 'Home',        'route' => 'home',             'name' => 'home'],
                        ['label' => 'About Us',     'route' => 'website.about',    'name' => 'website.about'],
                        ['label' => 'Departments',  'route' => 'website.services', 'name' => 'website.services'],
                        ['label' => 'Doctors',      'route' => 'website.doctors',  'name' => 'website.doctors'],
                        ['label' => 'Blog',         'route' => 'website.blog',     'name' => 'website.blog'],
                        ['label' => 'Contact',      'route' => 'website.contact',  'name' => 'website.contact'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @php
                        $isActive = request()->routeIs($item['name']) || request()->routeIs($item['name'].'.*');
                    @endphp
                    <a
                        href="{{ route($item['route']) }}"
                        class="{{ $isActive
                            ? 'bg-white text-blue-700 shadow-sm'
                            : 'text-white/90 hover:text-white hover:bg-white/15'
                        }} px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200"
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- Right: Socials + Auth --}}
            <div class="hidden lg:flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <a href="#" aria-label="Facebook" class="w-8 h-8 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-600 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter" class="w-8 h-8 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-600 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="w-8 h-8 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-600 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-linecap="round"/></svg>
                    </a>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-blue-600 transition-colors">Sign In</a>
                @endauth

                <a href="{{ route('website.contact') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-600/30 hidden xl:flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Book Now
                </a>
            </div>

            {{-- Mobile Hamburger --}}
            <button
                @click="open = !open"
                class="lg:hidden w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 hover:bg-blue-100 transition-colors"
                aria-label="Toggle menu"
                :aria-expanded="open"
            >
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Drawer --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden bg-white border-t border-gray-100 px-4 py-4 space-y-1"
        style="display: none;"
    >
        @php
            $mobileNav = [
                ['label' => 'Home',       'route' => 'home',             'name' => 'home'],
                ['label' => 'About Us',   'route' => 'website.about',    'name' => 'website.about'],
                ['label' => 'Departments','route' => 'website.services', 'name' => 'website.services'],
                ['label' => 'Doctors',    'route' => 'website.doctors',  'name' => 'website.doctors'],
                ['label' => 'Blog',       'route' => 'website.blog',     'name' => 'website.blog'],
                ['label' => 'Contact',    'route' => 'website.contact',  'name' => 'website.contact'],
            ];
        @endphp

        @foreach($mobileNav as $item)
            @php $mobileActive = request()->routeIs($item['name']) || request()->routeIs($item['name'].'.*'); @endphp
            <a
                href="{{ route($item['route']) }}"
                @click="open = false"
                class="{{ $mobileActive
                    ? 'bg-blue-600 text-white'
                    : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'
                }} block px-4 py-2.5 rounded-xl text-sm font-medium transition-colors"
            >
                {{ $item['label'] }}
            </a>
        @endforeach

        <div class="pt-2 border-t border-gray-100">
            <a href="{{ route('website.contact') }}" @click="open=false" class="block w-full text-center bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-blue-700 transition-colors">
                Book Appointment
            </a>
        </div>
    </div>
</nav>
