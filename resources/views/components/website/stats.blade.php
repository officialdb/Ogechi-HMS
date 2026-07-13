{{-- STATS SECTION --}}
<section class="py-16" style="background: linear-gradient(135deg, #062C77 0%, #0B5ED7 60%, #1565C8 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-0">

            @php
                $stats = [
                    ['value' => \Modules\Settings\Models\Setting::where('key', 'home_stats_patients')->value('value') ?: 25000, 'suffix' => '+', 'label' => 'Happy Patients', 'icon' => 'user-injured'],
                    ['value' => \Modules\Settings\Models\Setting::where('key', 'home_stats_doctors')->value('value') ?: 410, 'suffix' => '+', 'label' => 'Expert Doctors', 'icon' => 'user-md'],
                    ['value' => \Modules\Settings\Models\Setting::where('key', 'home_stats_experience')->value('value') ?: 17, 'suffix' => '+', 'label' => 'Years Experience', 'icon' => 'star'],
                    ['value' => \Modules\Settings\Models\Setting::where('key', 'home_stats_departments')->value('value') ?: 33, 'suffix' => 'k+', 'label' => 'Departments', 'icon' => 'hospital'],
                ];
            @endphp

            @foreach($stats as $index => $stat)
                <div class="flex flex-col items-center text-center py-6 {{ $index < 3 ? 'lg:border-r border-white/15' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white mb-4 backdrop-blur-sm">
                        @if($stat['icon'] == 'user-injured')
                            <x-fas-user-injured class="w-7 h-7" />
                        @elseif($stat['icon'] == 'user-md')
                            <x-fas-user-md class="w-7 h-7" />
                        @elseif($stat['icon'] == 'star')
                            <x-fas-star class="w-7 h-7" />
                        @elseif($stat['icon'] == 'hospital')
                            <x-fas-hospital class="w-7 h-7" />
                        @endif
                    </div>
                    <div class="flex items-baseline gap-1 mb-1">
                        <span
                            class="text-4xl lg:text-5xl font-black text-white"
                            data-count="{{ $stat['value'] }}"
                            data-suffix="{{ $stat['suffix'] }}"
                        >{{ $stat['value'] }}{{ $stat['suffix'] }}</span>
                    </div>
                    <p class="text-sm font-medium text-blue-200">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
