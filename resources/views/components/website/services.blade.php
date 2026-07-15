{{-- SERVICES SECTION --}}
<section id="services" class="py-20 lg:py-28 bg-[#F5F9FF]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-14" data-aos="fade-up">
            @php
                $servicesHeadline = \Modules\Settings\Models\Setting::where('key', 'home_services_headline')->value('value') ?: 'Extra Ordinary Health Solutions';
                $words = explode(' ', $servicesHeadline);
                if (count($words) > 2) {
                    $lastTwo = array_slice($words, -2);
                    $rest = array_slice($words, 0, count($words) - 2);
                    $formattedHeadline = implode(' ', $rest) . '<br> <span class="text-gradient">' . implode(' ', $lastTwo) . '</span>';
                } else {
                    $formattedHeadline = $servicesHeadline;
                }
            @endphp
            <div>
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-3">
                    <x-fas-arrow-right class="w-3.5 h-3.5" />
                    Our Department
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">
                    {!! $formattedHeadline !!}
                </h2>
            </div>
            <div class="flex flex-col items-start lg:items-end gap-4">
                <p class="text-gray-500 text-sm leading-relaxed max-w-sm">
                    At Ogechi Hospital, we focus on delivering healthcare services that prioritize patient comfort, safety, and trust.
                </p>
                <a href="{{ route('website.services') }}" class="inline-flex items-center gap-2 border-2 border-blue-600 text-blue-600 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300 w-fit">
                    More Department
                    <x-fas-arrow-right class="w-4 h-4" />
                </a>
            </div>
        </div>

        {{-- Service Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $departments = \Modules\Departments\Models\Department::where('status', 'active')->take(8)->get();
                $colorPalette = [
                    ['bg'=>'bg-red-50',    'text'=>'text-red-600',    'hover'=>'group-hover:bg-red-600',    'num'=>'text-red-200'],
                    ['bg'=>'bg-blue-50',   'text'=>'text-blue-600',   'hover'=>'group-hover:bg-blue-600',   'num'=>'text-blue-200'],
                    ['bg'=>'bg-violet-50', 'text'=>'text-violet-600', 'hover'=>'group-hover:bg-violet-600', 'num'=>'text-violet-200'],
                    ['bg'=>'bg-cyan-50',   'text'=>'text-cyan-600',   'hover'=>'group-hover:bg-cyan-600',   'num'=>'text-cyan-200'],
                    ['bg'=>'bg-green-50',  'text'=>'text-green-600',  'hover'=>'group-hover:bg-green-600',  'num'=>'text-green-200'],
                    ['bg'=>'bg-indigo-50', 'text'=>'text-indigo-600', 'hover'=>'group-hover:bg-indigo-600', 'num'=>'text-indigo-200'],
                    ['bg'=>'bg-pink-50',   'text'=>'text-pink-600',   'hover'=>'group-hover:bg-pink-600',   'num'=>'text-pink-200'],
                    ['bg'=>'bg-orange-50', 'text'=>'text-orange-600', 'hover'=>'group-hover:bg-orange-600', 'num'=>'text-orange-200'],
                ];
                $deptIcon = 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4';
            @endphp

            @foreach($departments as $index => $department)
                @php $c = $colorPalette[$index % count($colorPalette)]; @endphp
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-blue-900/10 p-6 border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2 flex flex-col gap-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                    {{-- Number --}}
                    <span class="text-4xl font-black {{ $c['num'] }} opacity-40 leading-none select-none">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>

                    {{-- Icon --}}
                    <div class="{{ $c['bg'] }} {{ $c['text'] }} w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 {{ $c['hover'] }} group-hover:text-white group-hover:shadow-lg">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $department['icon_path'] }}"/></svg>
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-col gap-2">
                        <h3 class="text-base font-bold text-gray-900 leading-snug group-hover:text-blue-700 transition-colors">{{ $department->name }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $department->description ?: 'Expert care and comprehensive medical services.' }}</p>
                    </div>

                    <a href="{{ route('website.contact') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors mt-auto">
                        Learn More
                        <x-fas-arrow-right class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
