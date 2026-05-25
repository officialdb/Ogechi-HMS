{{-- PROCESS SECTION --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        @php
            $processHeadline = \Modules\Settings\Models\Setting::where('key', 'home_process_headline')->value('value') ?: 'Simple Process We Follow';
            $words = explode(' ', $processHeadline);
            if (count($words) > 2) {
                $lastTwo = array_slice($words, -2);
                $rest = array_slice($words, 0, count($words) - 2);
                $formattedHeadline = implode(' ', $rest) . ' <span class="text-gradient">' . implode(' ', $lastTwo) . '</span>';
            } else {
                $formattedHeadline = $processHeadline;
            }
        @endphp
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                How We Work
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">
                {!! $formattedHeadline !!}
            </h2>
        </div>

        {{-- Process Steps --}}
        <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Connecting line (desktop only) --}}
            <div class="hidden lg:block absolute top-10 left-[calc(12.5%+20px)] right-[calc(12.5%+20px)] h-0.5 bg-gradient-to-r from-blue-200 via-blue-400 to-blue-200 z-0"></div>

            @php
                $steps = [
                    [
                        'step' => '01',
                        'title' => \Modules\Settings\Models\Setting::where('key', 'home_process_step1')->value('value') ?: 'Book Appointment',
                        'desc'  => 'Schedule your visit online or by phone at your convenience, day or night.',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                        'color' => 'bg-blue-600',
                    ],
                    [
                        'step' => '02',
                        'title' => \Modules\Settings\Models\Setting::where('key', 'home_process_step2')->value('value') ?: 'Doctor Consultation',
                        'desc'  => 'Meet with our qualified specialists for a thorough diagnosis and care plan.',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                        'color' => 'bg-indigo-600',
                    ],
                    [
                        'step' => '03',
                        'title' => \Modules\Settings\Models\Setting::where('key', 'home_process_step3')->value('value') ?: 'Treatment Plan',
                        'desc'  => 'Receive a personalized, evidence-based treatment plan tailored just for you.',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                        'color' => 'bg-violet-600',
                    ],
                    [
                        'step' => '04',
                        'title' => \Modules\Settings\Models\Setting::where('key', 'home_process_step4')->value('value') ?: 'Fast Recovery',
                        'desc'  => 'Our dedicated team ensures you recover quickly with continuous follow-up care.',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
                        'color' => 'bg-emerald-600',
                    ],
                ];
            @endphp

            @foreach($steps as $step)
                <div class="relative z-10 flex flex-col items-center text-center gap-4 group">
                    {{-- Step Icon Circle --}}
                    <div class="w-20 h-20 {{ $step['color'] }} rounded-full flex items-center justify-center shadow-xl shadow-blue-900/20 group-hover:scale-110 transition-transform duration-300 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            {!! $step['icon'] !!}
                        </svg>
                        {{-- Step number badge --}}
                        <span class="absolute -top-2 -right-2 w-7 h-7 bg-white border-2 border-gray-100 rounded-full text-xs font-bold text-gray-700 flex items-center justify-center shadow-md">{{ $step['step'] }}</span>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-900 text-base mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
