{{-- TESTIMONIALS SECTION --}}
<section class="py-20 lg:py-28 bg-[#F5F9FF]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        @php
            $testimonialsHeadline = \Modules\Settings\Models\Setting::where('key', 'home_testimonials_headline')->value('value') ?: 'Our Happy Patient\'s Genuine Reviews';
            $words = explode(' ', $testimonialsHeadline);
            if (count($words) > 2) {
                $lastTwo = array_slice($words, -2);
                $rest = array_slice($words, 0, count($words) - 2);
                $formattedHeadline = implode(' ', $rest) . '<br> <span class="text-gradient">' . implode(' ', $lastTwo) . '</span>';
            } else {
                $formattedHeadline = $testimonialsHeadline;
            }
        @endphp
        <div class="text-center mb-14" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-4">
                <x-fas-eye class="w-3.5 h-3.5" />
                Testimonials
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">
                {!! $formattedHeadline !!}
            </h2>
        </div>

        {{-- Testimonial Carousel --}}
        <div
            x-data="{
                active: 0,
                total: 3,
                autoplay: null,
                start() {
                    this.autoplay = setInterval(() => {
                        this.active = (this.active + 1) % this.total;
                    }, 5000);
                },
                stop() { clearInterval(this.autoplay); }
            }"
            x-init="start()"
            @mouseenter="stop()"
            @mouseleave="start()"
            class="relative"
        >
            {{-- Testimonial Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @php
                    $testimonials = [
                        [
                            'name'    => 'Jenny Nkemdirim',
                            'role'    => 'Patient – Cardiology',
                            'rating'  => 5,
                            'review'  => 'The care I received at Ogechi Hospital was exceptional. The doctors were attentive, compassionate and took time to explain everything clearly. I felt genuinely cared for throughout my treatment.',
                            'avatar_color' => '#F59E0B',
                            'bg'      => 'from-blue-50 to-white',
                        ],
                        [
                            'name'    => 'Tunde Adeyemi',
                            'role'    => 'Patient – Orthopedics',
                            'rating'  => 5,
                            'review'  => 'World-class facilities and an incredibly professional staff. My surgery was seamless and the post-operative care was outstanding. I highly recommend Ogechi Hospital to anyone.',
                            'avatar_color' => '#3B82F6',
                            'bg'      => 'from-blue-600 to-blue-700',
                            'dark'    => true,
                        ],
                        [
                            'name'    => 'Chidinma Okafor',
                            'role'    => 'Patient – Neurology',
                            'rating'  => 5,
                            'review'  => 'From the moment I walked in, I knew I was in good hands. The neurologist was thorough and the support team made my recovery journey comfortable and stress-free. Truly a premium hospital.',
                            'avatar_color' => '#10B981',
                            'bg'      => 'from-blue-50 to-white',
                        ],
                    ];
                @endphp

                @foreach($testimonials as $index => $review)
                    <div
                        class="relative bg-gradient-to-br {{ $review['bg'] }} rounded-2xl p-6 shadow-sm hover:shadow-xl hover:shadow-blue-900/10 border {{ isset($review['dark']) ? 'border-blue-500' : 'border-gray-100 hover:border-blue-100' }} transition-all duration-300 hover:-translate-y-1 flex flex-col gap-4"
                        data-aos="fade-up" data-aos-delay="{{ $index * 150 }}"
                    >
                        {{-- Quote Icon --}}
                        <div class="absolute top-5 right-5 opacity-10 {{ isset($review['dark']) ? 'text-white' : 'text-blue-600' }}">
                            <x-fas-eye class="w-12 h-12" />
                        </div>

                        {{-- Stars --}}
                        <div class="flex gap-0.5">
                            @for($i = 0; $i < $review['rating']; $i++)
                                <x-fas-eye class="w-4 h-4 text-yellow-400" />
                            @endfor
                        </div>

                        {{-- Review Text --}}
                        <p class="text-sm leading-relaxed {{ isset($review['dark']) ? 'text-blue-100' : 'text-gray-600' }} flex-1">
                            "{{ $review['review'] }}"
                        </p>

                        {{-- Profile --}}
                        <div class="flex items-center gap-3 pt-3 {{ isset($review['dark']) ? 'border-t border-white/20' : 'border-t border-gray-100' }}">
                            {{-- Avatar --}}
                            <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0" style="background: {{ $review['avatar_color'] }}20;">
                                <svg viewBox="0 0 40 40" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="14" r="9" fill="{{ $review['avatar_color'] }}" opacity="0.9"/>
                                    <ellipse cx="20" cy="36" rx="16" ry="12" fill="{{ $review['avatar_color'] }}" opacity="0.7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold {{ isset($review['dark']) ? 'text-white' : 'text-gray-900' }}">{{ $review['name'] }}</p>
                                <p class="text-xs {{ isset($review['dark']) ? 'text-blue-200' : 'text-blue-600' }} font-medium">{{ $review['role'] }}</p>
                            </div>
                            {{-- Verified badge --}}
                            <div class="ml-auto">
                                <div class="w-7 h-7 bg-green-100 rounded-full flex items-center justify-center">
                                    <x-fas-eye class="w-4 h-4 text-green-600" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Dots Navigation --}}
            <div class="flex justify-center gap-2 mt-8">
                @foreach($testimonials as $i => $t)
                    <button
                        @click="active = {{ $i }}"
                        :class="active === {{ $i }} ? 'w-8 bg-blue-600' : 'w-2.5 bg-gray-300 hover:bg-blue-300'"
                        class="h-2.5 rounded-full transition-all duration-300"
                        aria-label="Go to testimonial {{ $i + 1 }}"
                    ></button>
                @endforeach
            </div>
        </div>
    </div>
</section>
