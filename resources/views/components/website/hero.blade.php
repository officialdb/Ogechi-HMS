{{-- HERO SECTION --}}
<section id="home" class="relative overflow-hidden min-h-[90vh] flex items-center bg-blue-900">

    {{-- Full-width Background Image --}}
    <div class="absolute inset-0 z-0">
        <img
            src="{{ asset('images/hero_bg.jpg') }}"
            alt="Ogechi Hospital"
            class="w-full h-full object-cover object-center"
        />
        {{-- Gradient overlay: strong blue left (text), transparent right --}}
        <div class="absolute inset-0" style="background: linear-gradient(95deg, rgba(6,28,77,0.95) 0%, rgba(6,28,77,0.85) 40%, rgba(6,28,77,0.40) 70%, rgba(0,0,0,0.1) 100%);"></div>
    </div>
    
    {{-- Abstract / Artistic Art in Background --}}
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
        {{-- Floating Circles --}}
        <div class="absolute top-10 left-10 w-64 h-64 border border-white/10 rounded-full"></div>
        <div class="absolute top-20 left-20 w-32 h-32 border border-white/10 rounded-full"></div>
        
        {{-- Top Right Blob --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-400/20 rounded-full blur-3xl -translate-y-1/4 translate-x-1/4"></div>
        
        {{-- Plus Signs Grid Pattern --}}
        <svg class="absolute bottom-20 left-10 w-48 h-48 text-white/5" viewBox="0 0 100 100">
            <pattern id="plusPattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <path d="M10 0v20M0 10h20" stroke="currentColor" stroke-width="2"/>
            </pattern>
            <rect x="0" y="0" width="100" height="100" fill="url(#plusPattern)"/>
        </svg>
    </div>

    {{-- Large OGECHI watermark --}}
    <div class="absolute bottom-0 left-0 right-0 flex items-end justify-center pointer-events-none select-none overflow-hidden h-32 z-10">
        <span class="text-[120px] font-black text-white/5 uppercase tracking-widest leading-none">OGECHI</span>
    </div>

    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-24 lg:py-0 lg:min-h-[90vh] flex items-center">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center w-full h-full">

            {{-- Left: Content --}}
            <div class="flex flex-col gap-6 pt-10" data-aos="fade-right">
                @php
                    $heroHeadline = \Modules\Settings\Models\Setting::where('key', 'home_hero_headline')->value('value') ?: 'Best Caring, Better Doctors';
                    $words = explode(' ', $heroHeadline);
                    if (count($words) > 2) {
                        $lastTwo = array_slice($words, -2);
                        $rest    = array_slice($words, 0, count($words) - 2);
                        $restStr = rtrim(implode(' ', $rest), ',');
                        $formattedHeadline = $restStr . ',<br><span class="text-blue-300">' . implode(' ', $lastTwo) . '</span>';
                    } else {
                        $formattedHeadline = $heroHeadline;
                    }
                    $heroDesc     = \Modules\Settings\Models\Setting::where('key', 'home_hero_description')->value('value') ?: 'Providing world-class healthcare with compassion and excellence. Your health is our priority, every single day.';
                    $contactPhone = \Modules\Settings\Models\Setting::where('key', 'contact_phone')->value('value') ?: '+234 800 123 4567';
                    $card1Title   = \Modules\Settings\Models\Setting::where('key', 'hero_card1_title')->value('value') ?: '24/7 Emergency Services';
                    $card1Desc    = \Modules\Settings\Models\Setting::where('key', 'hero_card1_desc')->value('value')  ?: 'Round-the-clock emergency care available for every patient, every day.';
                    $card2Title   = \Modules\Settings\Models\Setting::where('key', 'hero_card2_title')->value('value') ?: 'Skilled Medical Professionals';
                    $card2Desc    = \Modules\Settings\Models\Setting::where('key', 'hero_card2_desc')->value('value')  ?: 'Our certified specialists bring world-class expertise to every consultation.';
                @endphp



                {{-- Headline --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight drop-shadow-lg">
                    {!! $formattedHeadline !!}
                </h1>

                <p class="text-white/80 text-base lg:text-lg leading-relaxed max-w-md drop-shadow">
                    {{ $heroDesc }}
                </p>

                {{-- Stats row --}}
                <div class="flex items-center gap-6 pt-2">
                    <div class="text-center">
                        <p class="text-2xl font-black text-white">5K+</p>
                        <p class="text-white/60 text-xs font-medium">Patients Served</p>
                    </div>
                    <div class="w-px h-10 bg-white/20"></div>
                    <div class="text-center">
                        <p class="text-2xl font-black text-white">50+</p>
                        <p class="text-white/60 text-xs font-medium">Specialist Doctors</p>
                    </div>
                    <div class="w-px h-10 bg-white/20"></div>
                    <div class="text-center">
                        <p class="text-2xl font-black text-white">15+</p>
                        <p class="text-white/60 text-xs font-medium">Years Experience</p>
                    </div>
                </div>

                {{-- CTAs --}}
                <div class="flex flex-wrap gap-4 items-center mb-10">
                    <a href="#about" class="inline-flex items-center gap-2 bg-white text-blue-700 font-semibold text-sm px-6 py-3 rounded-xl hover:bg-blue-50 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 shadow-md">
                        Learn More
                        <x-fas-arrow-right class="w-4 h-4" />
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" class="inline-flex items-center gap-2 bg-transparent border-2 border-white/40 text-white font-semibold text-sm px-6 py-3 rounded-xl hover:bg-white/10 hover:border-white/60 transition-all duration-300">
                        <x-fas-phone class="w-4 h-4 text-blue-200" />
                        {{ $contactPhone }}
                    </a>
                </div>
            </div>

            {{-- Right: Doctor Image (doc_1.png) --}}
            <div class="relative flex justify-center lg:justify-end items-end h-full pt-10" data-aos="fade-up">
                
                {{-- Decorative artistic sketch behind doctor --}}
                <svg class="absolute top-1/4 right-0 w-32 h-32 text-white/20 pointer-events-none" viewBox="0 0 120 120" fill="none">
                    @for($i = 0; $i < 12; $i++)
                        <line x1="60" y1="60" x2="{{ 60 + 55 * cos(deg2rad($i * 30)) }}" y2="{{ 60 + 55 * sin(deg2rad($i * 30)) }}" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    @endfor
                </svg>

                <img
                    src="{{ asset('images/doc_1.png') }}"
                    alt="Ogechi Hospital Doctor"
                    class="relative z-10 w-full max-w-sm sm:max-w-md lg:max-w-none lg:w-[900px] xl:w-[1100px] object-contain object-bottom drop-shadow-2xl -mb-10 lg:-mb-24 xl:-mr-16"
                />
            </div>
        </div>
    </div>

    {{-- Floating Cards — right side, stacked horizontally --}}
    <div class="absolute right-6 lg:right-10 xl:right-16 bottom-10 lg:bottom-16 z-30 hidden lg:flex flex-row gap-4">
        {{-- Card 1 --}}
        <div class="float-anim bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl shadow-blue-900/30 p-4 w-52 border border-white/60" data-aos="zoom-in" data-aos-delay="400">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <x-fas-star class="w-5 h-5 text-blue-600" />
                </div>
                <p class="text-xs font-bold text-gray-900 leading-snug">{{ $card1Title }}</p>
            </div>
            <p class="text-[10px] text-gray-500 leading-relaxed">{{ $card1Desc }}</p>
        </div>

        {{-- Card 2 --}}
        <div class="float-anim-delay bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl shadow-blue-900/30 p-4 w-52 border border-white/60" data-aos="zoom-in" data-aos-delay="600">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <x-fas-user-md class="w-5 h-5 text-green-600" />
                </div>
                <p class="text-xs font-bold text-gray-900 leading-snug">{{ $card2Title }}</p>
            </div>
            <p class="text-[10px] text-gray-500 leading-relaxed">{{ $card2Desc }}</p>
        </div>
    </div>

</section>
