{{-- STATS SECTION --}}
<section class="py-16" style="background: linear-gradient(135deg, #062C77 0%, #0B5ED7 60%, #1565C8 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-0">

            @php
                $stats = [
                    ['value' => \Modules\Settings\Models\Setting::where('key', 'home_stats_patients')->value('value') ?: 25000, 'suffix' => '+', 'label' => 'Happy Patients', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>'],
                    ['value' => \Modules\Settings\Models\Setting::where('key', 'home_stats_doctors')->value('value') ?: 410, 'suffix' => '+', 'label' => 'Expert Doctors', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'],
                    ['value' => \Modules\Settings\Models\Setting::where('key', 'home_stats_experience')->value('value') ?: 17, 'suffix' => '+', 'label' => 'Years Experience', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>'],
                    ['value' => \Modules\Settings\Models\Setting::where('key', 'home_stats_departments')->value('value') ?: 33, 'suffix' => 'k+', 'label' => 'Departments', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'],
                ];
            @endphp

            @foreach($stats as $index => $stat)
                <div class="flex flex-col items-center text-center py-6 {{ $index < 3 ? 'lg:border-r border-white/15' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white mb-4 backdrop-blur-sm">
                        {!! $stat['icon'] !!}
                    </div>
                    <div class="flex items-baseline gap-1 mb-1">
                        <span
                            class="text-4xl lg:text-5xl font-black text-white"
                            data-count="{{ $stat['value'] }}"
                            data-suffix="{{ $stat['suffix'] }}"
                        >0{{ $stat['suffix'] }}</span>
                    </div>
                    <p class="text-sm font-medium text-blue-200">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
