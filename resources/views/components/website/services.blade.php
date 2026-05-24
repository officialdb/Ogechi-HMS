{{-- SERVICES SECTION --}}
<section id="services" class="py-20 lg:py-28 bg-[#F5F9FF]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-14">
            <div>
                <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    Our Department
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">
                    Extra Ordinary<br>
                    <span class="text-gradient">Health Solutions</span>
                </h2>
            </div>
            <div class="flex flex-col items-start lg:items-end gap-4">
                <p class="text-gray-500 text-sm leading-relaxed max-w-sm">
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
                <a href="#" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-600/30 hover:-translate-y-0.5">
                    More Department
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Service Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $services = [
                    [
                        'number' => '01',
                        'title' => 'Orthopedic Care Sector',
                        'description' => 'Orci quis tat longucat cubitur et pulvinar hughi. Amet non facilisis quisque volutpat dic, quis.',
                        'color' => 'blue',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
                    ],
                    [
                        'number' => '02',
                        'title' => 'Dentistry Department',
                        'description' => 'Orci quis tat longucat cubitur et pulvinar hughi. Amet non facilisis quisque volutpat dic, quis.',
                        'color' => 'indigo',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    ],
                    [
                        'number' => '03',
                        'title' => 'Neurology Department',
                        'description' => 'Orci quis tat longucat cubitur et pulvinar hughi. Amet non facilisis quisque volutpat dic, quis.',
                        'color' => 'violet',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>',
                    ],
                    [
                        'number' => '04',
                        'title' => 'Cardiology Sector',
                        'description' => 'Orci quis tat longucat cubitur et pulvinar hughi. Amet non facilisis quisque volutpat dic, quis.',
                        'color' => 'red',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
                    ],
                ];
                $colorMap = [
                    'blue'   => ['bg' => 'bg-blue-50',   'icon' => 'text-blue-600',   'hover_bg' => 'group-hover:bg-blue-600',   'number' => 'text-blue-200'],
                    'indigo' => ['bg' => 'bg-indigo-50', 'icon' => 'text-indigo-600', 'hover_bg' => 'group-hover:bg-indigo-600', 'number' => 'text-indigo-200'],
                    'violet' => ['bg' => 'bg-violet-50', 'icon' => 'text-violet-600', 'hover_bg' => 'group-hover:bg-violet-600', 'number' => 'text-violet-200'],
                    'red'    => ['bg' => 'bg-red-50',    'icon' => 'text-red-600',    'hover_bg' => 'group-hover:bg-red-500',    'number' => 'text-red-200'],
                ];
            @endphp

            @foreach($services as $service)
                @php $colors = $colorMap[$service['color']]; @endphp
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-blue-900/10 p-6 border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2 flex flex-col gap-4">

                    {{-- Number --}}
                    <span class="text-4xl font-black {{ $colors['number'] }} opacity-40 leading-none select-none">{{ $service['number'] }}</span>

                    {{-- Icon --}}
                    <div class="{{ $colors['bg'] }} {{ $colors['icon'] }} w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 {{ $colors['hover_bg'] }} group-hover:text-white group-hover:shadow-lg">
                        {!! $service['icon'] !!}
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-col gap-2">
                        <h3 class="text-base font-bold text-gray-900 leading-snug group-hover:text-blue-700 transition-colors">{{ $service['title'] }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $service['description'] }}</p>
                    </div>

                    <a href="#" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors mt-auto">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
