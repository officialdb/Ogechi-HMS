{{-- ABOUT / MEDICAL CENTER SECTION --}}
<section id="about" class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            {{-- Left: Images Grid --}}
            <div class="relative" data-aos="fade-right">
                <div class="flex gap-4">
                    {{-- Column 1 --}}
                    <div class="flex flex-col gap-4 flex-1">
                        {{-- Large Image --}}
                        <div class="rounded-2xl overflow-hidden h-64 sm:h-80 bg-gradient-to-br from-blue-800 to-blue-600 relative group">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/60 to-transparent z-10"></div>
                            {{-- Medical team SVG illustration --}}
                            <svg viewBox="0 0 300 320" class="w-full h-full object-cover" xmlns="http://www.w3.org/2000/svg">
                                <rect width="300" height="320" fill="#1E40AF"/>
                                {{-- Background shapes --}}
                                <circle cx="250" cy="50" r="80" fill="#2563EB" opacity="0.4"/>
                                <circle cx="50" cy="280" r="60" fill="#1D4ED8" opacity="0.3"/>
                                {{-- Figure 1 --}}
                                <ellipse cx="100" cy="220" rx="45" ry="80" fill="#1E3A8A"/>
                                <circle cx="100" cy="130" r="28" fill="#FCD34D"/>
                                <rect cx="100" cy="155" width="20" height="25" fill="#F59E0B"/>
                                {{-- Figure 2 (doctor) --}}
                                <ellipse cx="190" cy="230" rx="50" ry="85" fill="#2563EB"/>
                                <circle cx="190" cy="135" r="30" fill="#FDE68A"/>
                                <rect x="175" y="160" width="15" height="28" rx="3" fill="#F59E0B"/>
                                {{-- Lab coats --}}
                                <rect x="165" y="180" width="50" height="110" rx="5" fill="#3B82F6" opacity="0.5"/>
                                <rect x="75" y="175" width="50" height="110" rx="5" fill="#1E3A8A" opacity="0.5"/>
                                {{-- Clipboard --}}
                                <rect x="195" y="210" width="25" height="35" rx="3" fill="white" opacity="0.8"/>
                                <line x1="200" y1="220" x2="214" y2="220" stroke="#94A3B8" stroke-width="2"/>
                                <line x1="200" y1="228" x2="214" y2="228" stroke="#94A3B8" stroke-width="2"/>
                                <line x1="200" y1="236" x2="210" y2="236" stroke="#94A3B8" stroke-width="2"/>
                                {{-- Cross symbol --}}
                                <rect x="182" y="195" width="12" height="4" rx="1" fill="white" opacity="0.9"/>
                                <rect x="186" y="191" width="4" height="12" rx="1" fill="white" opacity="0.9"/>
                            </svg>
                            {{-- Play button --}}
                            <div class="absolute inset-0 z-20 flex items-center justify-center">
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform cursor-pointer hover:bg-white/30">
                                    <x-fas-user-md class="w-6 h-6 text-white ml-1" />
                                </div>
                            </div>
                        </div>

                        {{-- Small Image 2 (Indigo) --}}
                        <div class="hidden sm:block rounded-2xl overflow-hidden h-40 bg-gradient-to-br from-blue-500 to-indigo-700 relative">
                            <x-fas-user-md class="w-full h-full" />
                        </div>
                    </div>

                    {{-- Column 2 --}}
                    <div class="hidden sm:flex flex-col gap-4 flex-1">
                        {{-- Small Image 1 (Teal) --}}
                        <div class="rounded-2xl overflow-hidden h-40 bg-gradient-to-br from-cyan-600 to-blue-700 relative">
                            <svg viewBox="0 0 150 160" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                                <rect width="150" height="160" fill="#0891B2"/>
                                <circle cx="75" cy="60" r="35" fill="#0E7490" opacity="0.7"/>
                                <ellipse cx="75" cy="130" rx="50" ry="40" fill="#155E75"/>
                                <circle cx="75" cy="55" r="20" fill="#FDE68A"/>
                                <rect x="60" y="72" width="30" height="55" rx="5" fill="#0C4A6E" opacity="0.8"/>
                                <rect x="60" y="72" width="30" height="55" rx="5" fill="white" opacity="0.2"/>
                            </svg>
                        </div>

                        {{-- Small Image 3 (Heartbeat pulse, now h-80) --}}
                        <div class="rounded-2xl overflow-hidden h-80 bg-gradient-to-br from-rose-500 to-red-700 relative flex items-center justify-center">
                            <x-fas-user-md class="w-full h-full" />
                        </div>
                    </div>
                </div>

                {{-- Experience badge --}}
                <div class="absolute -bottom-4 left-4 bg-blue-600 text-white rounded-2xl px-5 py-3 shadow-xl shadow-blue-600/30 float-anim">
                    <p class="text-2xl font-black">17+</p>
                    <p class="text-xs font-medium opacity-80">Years of Excellence</p>
                </div>
            </div>

            {{-- Right: Content --}}
            @php
                $aboutHeadline = \Modules\Settings\Models\Setting::where('key', 'home_about_headline')->value('value') ?: 'We Are Best Professional In Medical Sectors';
                // Split the headline so the last two words are wrapped in gradient span
                $words = explode(' ', $aboutHeadline);
                if (count($words) > 2) {
                    $lastTwo = array_slice($words, -2);
                    $rest = array_slice($words, 0, count($words) - 2);
                    $formattedHeadline = implode(' ', $rest) . '<br> <span class="text-gradient">' . implode(' ', $lastTwo) . '</span>';
                } else {
                    $formattedHeadline = $aboutHeadline;
                }
                $aboutDesc = \Modules\Settings\Models\Setting::where('key', 'home_about_description')->value('value') ?: 'Fugiat ut voluptate quo. Occaecat hic aute corporis culpitur facilius laboris excepteur, labore et Repnat emdolit. Patturiam, sint aute risus ture.';
            @endphp
            <div class="flex flex-col gap-6" data-aos="fade-left">
                <div>
                    <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-4">
                        <x-fas-arrow-right class="w-3.5 h-3.5" />
                        Introduction To Us
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">
                        {!! $formattedHeadline !!}
                    </h2>
                </div>

                <p class="text-gray-500 text-sm leading-relaxed">
                    {{ $aboutDesc }}
                </p>

                {{-- Benefits List --}}
                <ul class="space-y-3">
                    @foreach([
                        'Fusce necessitatibus facillius nisi.',
                        'Culiusdam sit as pulvinar hugi.',
                        'Tincue illo alasmod pede ornare.',
                        'Sicet nam feculis alasmod pede ornare.',
                    ] as $benefit)
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center mt-0.5 flex-shrink-0">
                                <x-fas-check class="w-3 h-3 text-white" />
                            </div>
                            <span class="text-sm text-gray-700">{{ $benefit }}</span>
                        </li>
                    @endforeach
                </ul>

                {{-- Opening Hours Card --}}
                <div class="bg-blue-600 rounded-2xl p-5 text-white">
                    <div class="flex items-center gap-2 mb-4">
                        <x-fas-chart-bar class="w-5 h-5 text-blue-200" />
                        <h3 class="font-bold text-base">Opening Hours</h3>
                    </div>
                    <p class="text-blue-100 text-xs mb-4 leading-relaxed">Orci quis tat longucat cubitur et pulvinar hugi. Amet non facilisis.</p>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-blue-200 font-medium">Mon - Fri</span>
                            <span class="font-bold text-white bg-white/10 px-3 py-1 rounded-lg">8AM – 10PM</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-blue-200 font-medium">Sat - Sun</span>
                            <span class="font-bold text-white bg-white/10 px-3 py-1 rounded-lg">7AM – 8PM</span>
                        </div>
                        <div class="flex items-center gap-2 pt-2 border-t border-white/20">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-xs text-blue-100 font-medium">24/7 Emergency Care Open</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
