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
                        <div class="relative">
                            <div class="rounded-2xl overflow-hidden h-64 sm:h-80 relative group">
                                <img src="{{ asset('/images/emergency room.jfif') }}" alt="Medical team" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-blue-900/60 to-transparent z-10"></div>
                            </div>

                            {{-- Smaller stacked image overlay --}}
                            <div class="absolute -bottom-6 -right-6 w-32 h-32 sm:w-40 sm:h-40 rounded-2xl overflow-hidden border-4 border-white shadow-xl z-20">
                                <img src="{{ asset('/images/female doctor.jfif') }}" alt="Doctor" class="w-full h-full object-cover">
                            </div>
                        </div>

                        {{-- Small Image 2 (Indigo) --}}
                    <div class="hidden sm:block rounded-2xl overflow-hidden h-40 bg-gradient-to-br from-blue-500 to-indigo-700 relative">
                        <img 
                            src="{{ asset('/images/Drip.jfif') }}" 
                            alt="Doctors" 
                            class="w-full h-full object-cover"
                        />
                    </div>
                    </div>

                    {{-- Column 2 --}}
                    <div class="hidden sm:flex flex-col gap-4 flex-1">
                        {{-- Small Image 1 (Teal) --}}
                        <div class="rounded-2xl overflow-hidden h-40 relative">
                            <img src="{{ asset('/images/operating room.jfif') }}" alt="Doctor consultation" class="w-full h-full object-cover object-[50%_20%]">
                        </div>

                        {{-- Small Image 3 --}}
                        <div class="rounded-2xl overflow-hidden h-80 relative">
                            <img src="{{ asset('images/small doc1.jfif') }}" alt="Patient care" class="w-full h-full object-cover">
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
