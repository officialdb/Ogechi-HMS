{{-- CTA SECTION --}}
<section id="appointment" class="py-20 relative overflow-hidden" style="background: linear-gradient(135deg, #062C77 0%, #0B5ED7 60%, #1565C8 100%);">

    {{-- Decorative elements --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12">

            {{-- Left: Doctor Illustration --}}
            <div class="relative hidden lg:flex gap-4 items-end" data-aos="fade-right">
                {{-- Doctor 1 --}}
                <div class="w-36 h-52 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/20">
                    <svg viewBox="0 0 144 208" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <rect width="144" height="208" fill="rgba(255,255,255,0.05)"/>
                        <ellipse cx="72" cy="155" rx="50" ry="65" fill="#1E3A8A"/>
                        <rect x="52" y="120" width="40" height="80" rx="5" fill="white" opacity="0.15"/>
                        <circle cx="72" cy="88" r="30" fill="#FCD34D"/>
                        <ellipse cx="72" cy="63" rx="30" ry="18" fill="#1E3A5F"/>
                        <rect x="60" y="114" width="24" height="18" rx="3" fill="#F59E0B"/>
                    </svg>
                </div>
                {{-- Doctor 2 (larger) --}}
                <div class="w-44 h-64 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/20 -mt-12">
                    <svg viewBox="0 0 176 256" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <rect width="176" height="256" fill="rgba(255,255,255,0.08)"/>
                        <ellipse cx="88" cy="190" rx="60" ry="80" fill="#2563EB"/>
                        <rect x="63" y="148" width="50" height="100" rx="5" fill="white" opacity="0.15"/>
                        <circle cx="88" cy="108" r="35" fill="#FDE68A"/>
                        <ellipse cx="88" cy="78" rx="35" ry="22" fill="#1E3A5F"/>
                        <rect x="74" y="140" width="28" height="20" rx="4" fill="#F59E0B"/>
                        <path d="M70 165 Q58 195 63 215 Q68 235 88 238 Q108 235 113 215 Q118 195 106 165" fill="none" stroke="rgba(200,210,255,0.6)" stroke-width="3.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            {{-- Center/Right: CTA Content --}}
            @php
                $ctaHeadline = \Modules\Settings\Models\Setting::where('key', 'home_cta_headline')->value('value') ?: 'Best Caring For You';
                $words = explode(' ', $ctaHeadline);
                if (count($words) > 2) {
                    $lastTwo = array_slice($words, -2);
                    $rest = array_slice($words, 0, count($words) - 2);
                    $formattedHeadline = implode(' ', $rest) . '<br> <span class="text-blue-200">' . implode(' ', $lastTwo) . '</span>';
                } else {
                    $formattedHeadline = $ctaHeadline;
                }
                $ctaDesc = \Modules\Settings\Models\Setting::where('key', 'home_cta_description')->value('value') ?: 'Our dedicated team of medical professionals is here around the clock to provide you with the best possible care. Book your appointment today.';
            @endphp
            <div class="flex-1 flex flex-col gap-6 text-center lg:text-left" data-aos="fade-up">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 text-xs font-semibold text-white/80 uppercase tracking-wider mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Caring For You
                    </div>
                    <h2 class="text-3xl lg:text-4xl xl:text-5xl font-bold text-white leading-tight">
                        {!! $formattedHeadline !!}
                    </h2>
                </div>
                <p class="text-white/75 text-base leading-relaxed max-w-lg mx-auto lg:mx-0">
                    {{ $ctaDesc }}
                </p>

                {{-- Appointment Form --}}
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6">
                    <h3 class="text-white font-semibold text-base mb-4">Let's Book Your Appointment</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <input
                            type="text"
                            placeholder="Your Full Name"
                            class="w-full bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/40"
                        >
                        <input
                            type="tel"
                            placeholder="Phone Number"
                            class="w-full bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/40"
                        >
                        <select class="w-full bg-white/10 border border-white/20 text-white/70 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-white/30">
                            <option value="" class="text-gray-800">Select Department</option>
                            <option value="cardiology" class="text-gray-800">Cardiology</option>
                            <option value="orthopedic" class="text-gray-800">Orthopedic</option>
                            <option value="neurology" class="text-gray-800">Neurology</option>
                            <option value="dentistry" class="text-gray-800">Dentistry</option>
                        </select>
                        <input
                            type="date"
                            class="w-full bg-white/10 border border-white/20 text-white/70 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-white/30"
                        >
                    </div>
                    <button class="w-full bg-white text-blue-700 font-semibold text-sm py-3 rounded-xl hover:bg-blue-50 transition-all duration-300 hover:shadow-lg flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Book Appointment Now
                    </button>
                </div>
            </div>

            {{-- Right: Extra Doctor --}}
            <div class="relative hidden xl:flex items-end" data-aos="fade-left">
                <div class="w-44 h-64 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/20">
                    <svg viewBox="0 0 176 256" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <rect width="176" height="256" fill="rgba(255,255,255,0.06)"/>
                        <ellipse cx="88" cy="195" rx="55" ry="75" fill="#5B21B6"/>
                        <rect x="65" y="155" width="46" height="95" rx="5" fill="white" opacity="0.1"/>
                        <circle cx="88" cy="110" r="32" fill="#FBBF24"/>
                        <ellipse cx="88" cy="83" rx="32" ry="19" fill="#3730A3"/>
                        <rect x="75" y="138" width="26" height="20" rx="4" fill="#F59E0B"/>
                        <path d="M72 162 Q60 192 66 212 Q72 232 88 235 Q104 232 110 212 Q116 192 104 162" fill="none" stroke="rgba(180,190,255,0.6)" stroke-width="3.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
