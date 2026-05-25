{{-- HERO SECTION --}}
<section id="home" class="relative overflow-hidden min-h-[90vh] flex items-center" style="background: linear-gradient(135deg, #062C77 0%, #0B4DB5 55%, #1565C8 100%);">

    {{-- Decorative Blobs --}}
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-400/10 rounded-full blur-3xl -translate-y-32 translate-x-32 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-white/5 rounded-full blur-2xl translate-y-20 -translate-x-20 pointer-events-none"></div>

    {{-- Large MEDICAL watermark --}}
    <div class="absolute bottom-0 left-0 right-0 flex items-end justify-center pointer-events-none select-none overflow-hidden h-32">
        <span class="text-[120px] font-black text-white/5 uppercase tracking-widest leading-none">MEDICAL</span>
    </div>

    {{-- Curved shape bottom --}}
    <div class="absolute bottom-0 left-0 right-0 h-20 bg-white" style="border-radius: 100% 100% 0 0 / 60px 60px 0 0;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-20 lg:py-0 lg:min-h-[90vh] flex items-center">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-0 items-end w-full">

            {{-- Left: Content --}}
            <div class="order-2 lg:order-1 pb-12 lg:pb-28 pt-8 lg:pt-0 flex flex-col gap-6">

                {{-- Trust Badge --}}
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span class="text-xs font-semibold text-white/80 uppercase tracking-widest">Health & Medical</span>
                </div>

                @php
                    $heroHeadline = \Modules\Settings\Models\Setting::where('key', 'home_hero_headline')->value('value') ?: 'Best Caring, Better Doctors';
                    // We split the headline assuming the last two words should be blue.
                    $words = explode(' ', $heroHeadline);
                    if (count($words) > 2) {
                        $lastTwo = array_slice($words, -2);
                        $rest = array_slice($words, 0, count($words) - 2);
                        $formattedHeadline = implode(' ', $rest) . ',<br><span class="text-blue-300">' . implode(' ', $lastTwo) . '</span>';
                    } else {
                        $formattedHeadline = $heroHeadline;
                    }
                    $heroDesc = \Modules\Settings\Models\Setting::where('key', 'home_hero_description')->value('value') ?: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua, ut enim ad minim veniam.';
                @endphp

                {{-- Headline --}}
                <div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                        {!! $formattedHeadline !!}
                    </h1>
                </div>

                <p class="text-white/75 text-base lg:text-lg leading-relaxed max-w-md">
                    {{ $heroDesc }}
                </p>

                {{-- CTAs --}}
                <div class="flex flex-wrap gap-4 items-center">
                    <a href="#about" class="inline-flex items-center gap-2 bg-white text-blue-700 font-semibold text-sm px-6 py-3 rounded-xl hover:bg-blue-50 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 shadow-md">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="tel:+2348001234567" class="inline-flex items-center gap-2 bg-transparent border-2 border-white/40 text-white font-semibold text-sm px-6 py-3 rounded-xl hover:bg-white/10 hover:border-white/60 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        +234 800 123 4567
                    </a>
                </div>
            </div>

            {{-- Right: Doctor Image --}}
            <div class="order-1 lg:order-2 relative flex justify-center lg:justify-end items-end">
                {{-- Doctor placeholder (styled div) --}}
                <div class="relative z-10 w-72 sm:w-80 lg:w-96">
                    <div class="relative bg-gradient-to-b from-blue-400/20 to-transparent rounded-t-full overflow-hidden" style="height: 520px;">
                        {{-- Doctor silhouette SVG --}}
                        <svg viewBox="0 0 320 520" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                            {{-- Body/Coat --}}
                            <ellipse cx="160" cy="380" rx="100" ry="150" fill="#1E40AF" opacity="0.9"/>
                            {{-- Lab Coat Detail --}}
                            <rect x="120" y="280" width="80" height="200" rx="5" fill="#3B82F6" opacity="0.4"/>
                            {{-- Stethoscope --}}
                            <path d="M145 300 Q135 330 140 350 Q145 370 160 375 Q175 370 180 350 Q185 330 175 300" fill="none" stroke="#93C5FD" stroke-width="4" stroke-linecap="round"/>
                            {{-- Head --}}
                            <ellipse cx="160" cy="200" rx="55" ry="65" fill="#FBBF24" opacity="0.85"/>
                            {{-- Hair --}}
                            <ellipse cx="160" cy="155" rx="55" ry="30" fill="#1E3A5F"/>
                            {{-- Neck --}}
                            <rect x="145" y="255" width="30" height="35" rx="5" fill="#F59E0B" opacity="0.85"/>
                            {{-- Arms folded hint --}}
                            <ellipse cx="105" cy="335" rx="30" ry="18" fill="#1E40AF" opacity="0.9"/>
                            <ellipse cx="215" cy="335" rx="30" ry="18" fill="#1E40AF" opacity="0.9"/>
                            {{-- Cross badge --}}
                            <rect x="148" y="310" width="24" height="8" rx="2" fill="#60A5FA"/>
                            <rect x="156" y="302" width="8" height="24" rx="2" fill="#60A5FA"/>
                        </svg>
                    </div>
                </div>

                {{-- Floating Card 1: Emergency Services --}}
                <div class="float-anim absolute -left-4 lg:-left-8 bottom-32 lg:bottom-40 bg-white rounded-2xl shadow-xl shadow-blue-900/20 p-4 w-48 border border-blue-50 z-20">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900 leading-tight">24*7 Emergency</p>
                            <p class="text-xs font-bold text-gray-900">Services</p>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-500 leading-relaxed">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>

                {{-- Floating Card 2: Skilled Professionals --}}
                <div class="float-anim-delay absolute -right-2 lg:-right-4 bottom-32 lg:bottom-40 bg-white rounded-2xl shadow-xl shadow-blue-900/20 p-4 w-48 border border-blue-50 z-20">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900 leading-tight">Skilled Medical</p>
                            <p class="text-xs font-bold text-gray-900">Professionals</p>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-500 leading-relaxed">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
        </div>
    </div>
</section>
