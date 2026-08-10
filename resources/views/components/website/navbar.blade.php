{{-- Main Navigation --}}
<nav
    id="main-navbar"
    x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 80)"
    class="sticky top-0 z-50 transition-all duration-300 bg-white border-b border-gray-100"
    :class="{ 'shadow-lg shadow-blue-900/10 bg-white/95 backdrop-blur-md': scrolled }"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Mobile Logo --}}
            @php
                $siteLogo = \Modules\Settings\Models\Setting::where('key', 'site_logo')->value('value');
                $appName = \Modules\Settings\Models\Setting::where('key', 'app_name')->value('value') ?: 'Ogechi Hospital';
            @endphp
            <a href="{{ route('home') }}" class="flex items-center gap-2 lg:hidden">
                @if($siteLogo)
                    <img src="{{ Storage::url($siteLogo) }}" alt="{{ $appName }}" class="h-8 object-contain">
                @else
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                        <x-fas-hospital class="w-4 h-4 text-white" />
                    </div>
                    <span class="font-bold text-gray-900 text-base">{{ $appName }}</span>
                @endif
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
                    <a href="javascript:void(0)" aria-label="Facebook" class="w-8 h-8 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-600 transition-colors">
                        <x-fab-facebook-f class="w-3.5 h-3.5" />
                    </a>
                    <a href="javascript:void(0)" aria-label="Twitter" class="w-8 h-8 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-600 transition-colors">
                        <x-fab-twitter class="w-3.5 h-3.5" />
                    </a>
                    <a href="javascript:void(0)" aria-label="Instagram" class="w-8 h-8 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-600 transition-colors">
                        <x-fab-instagram class="w-3.5 h-3.5" />
                    </a>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-blue-600 transition-colors">Sign In</a>
                @endauth

                <a href="{{ route('website.contact') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-600/30 hidden xl:flex items-center gap-1.5">
                    <x-fas-calendar-check class="w-3.5 h-3.5" />
                    Book Now
                </a>
            </div>

            {{-- Mobile Hamburger --}}
            <button
                @click="open = !open"
                class="lg:hidden w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 hover:bg-blue-100 transition-colors relative"
                aria-label="Toggle menu"
                :aria-expanded="open"
            >
                <x-fas-bars x-show="!open" class="w-5 h-5 absolute" />
                <x-fas-times x-show="open" class="w-5 h-5 absolute" style="display: none;" />
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
