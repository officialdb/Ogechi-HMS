{{-- CTA SECTION --}}
<section id="appointment" class="py-20 relative overflow-hidden" style="background: linear-gradient(135deg, #062C77 0%, #0B5ED7 60%, #1565C8 100%);">

    {{-- Decorative elements --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12">

            {{-- Left: Doctor Illustration --}}
                        {{-- Doctor 1 --}}
                    <div class="w-36 h-52 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/20">
                        <img src="{{ asset('/images/doc n patient.jfif') }}" alt="Doctor" class="w-full h-full object-cover">
                    </div>
                {{-- Doctor 2 (larger) --}}
                <div class="w-44 h-64 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/20 -mt-12">
                    <img src="{{ asset('/images/small doc1.jfif') }}" alt="Doctors" class="w-full h-full object-cover">
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
                        <x-fas-heart class="w-3.5 h-3.5 text-blue-200" />
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
                        <x-fas-calendar-check class="w-4 h-4" />
                        Book Appointment Now
                    </button>
                </div>
            </div>

            {{-- Right: Extra Doctor --}}
                <div class="w-44 h-64 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/20 -mt-12">
    <img src="{{ asset('/images/female doctor.jfif') }}" alt="Doctors" class="w-full h-full object-cover">
</div>
                </div>
            </div>
        </div>
    </div>
</section>


 <!--<div class="w-44 h-64 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/20 -mt-12">
                    <x-fas-user-md class="w-full h-full" />
                </div>-->