<x-layouts.website title="Departments – Ogechi Hospital" metaDescription="Explore all medical departments at Ogechi Hospital — from Cardiology and Neurology to Dentistry and Orthopedics. Expert care across every specialty.">

    <x-website.header-bar />
    <x-website.navbar />

    <x-website.page-hero
        title="Our Departments"
        subtitle="World-class care across every medical specialty. Our expert teams work together to deliver seamless, comprehensive healthcare."
        :breadcrumbs="[['label'=>'Home','route'=>'home'],['label'=>'Departments']]"
        icon="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
    />

    {{-- All Departments Grid ---------------------------------------------- --}}
    <section class="py-20 lg:py-28 bg-[#F5F9FF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-4">All Specialties</div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Extra Ordinary <span class="text-gradient">Health Solutions</span></h2>
                <p class="text-gray-500 text-sm mt-3 max-w-xl mx-auto leading-relaxed">Our departments are staffed by board-certified specialists with decades of combined experience in their respective fields.</p>
            </div>

            @php
                $colorPalette = [
                    ['bg'=>'bg-red-50',    'text'=>'text-red-600',    'hover'=>'group-hover:bg-red-600',    'num'=>'text-red-200'],
                    ['bg'=>'bg-blue-50',   'text'=>'text-blue-600',   'hover'=>'group-hover:bg-blue-600',   'num'=>'text-blue-200'],
                    ['bg'=>'bg-violet-50', 'text'=>'text-violet-600', 'hover'=>'group-hover:bg-violet-600', 'num'=>'text-violet-200'],
                    ['bg'=>'bg-cyan-50',   'text'=>'text-cyan-600',   'hover'=>'group-hover:bg-cyan-600',   'num'=>'text-cyan-200'],
                    ['bg'=>'bg-green-50',  'text'=>'text-green-600',  'hover'=>'group-hover:bg-green-600',  'num'=>'text-green-200'],
                    ['bg'=>'bg-indigo-50', 'text'=>'text-indigo-600', 'hover'=>'group-hover:bg-indigo-600', 'num'=>'text-indigo-200'],
                    ['bg'=>'bg-pink-50',   'text'=>'text-pink-600',   'hover'=>'group-hover:bg-pink-600',   'num'=>'text-pink-200'],
                    ['bg'=>'bg-orange-50', 'text'=>'text-orange-600', 'hover'=>'group-hover:bg-orange-600', 'num'=>'text-orange-200'],
                    ['bg'=>'bg-teal-50',   'text'=>'text-teal-600',   'hover'=>'group-hover:bg-teal-600',   'num'=>'text-teal-200'],
                    ['bg'=>'bg-rose-50',   'text'=>'text-rose-600',   'hover'=>'group-hover:bg-rose-600',   'num'=>'text-rose-200'],
                ];
                // Generic hospital department SVG icon path
                $deptIcon = 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4';
            @endphp

            @if($departments->isEmpty())
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-blue-100">
                        <x-fas-eye class="w-10 h-10 text-blue-300" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Departments Coming Soon</h3>
                    <p class="text-gray-500 text-sm max-w-sm mx-auto">Our department listings will appear here once configured. Please check back soon.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($departments as $i => $dept)
                        @php $c = $colorPalette[$i % count($colorPalette)]; @endphp
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-blue-900/10 p-6 border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2 flex flex-col gap-4">
                            <span class="text-4xl font-black {{ $c['num'] }} opacity-40 leading-none select-none">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="{{ $c['bg'] }} {{ $c['text'] }} w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 {{ $c['hover'] }} group-hover:text-white group-hover:shadow-lg">
                                <x-fas-eye class="w-7 h-7" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-base mb-2 group-hover:text-blue-700 transition-colors">{{ $dept->name }}</h3>
                                <p class="text-xs text-gray-500 leading-relaxed">
                                    {{ $dept->description ?: 'Expert care and comprehensive medical services provided by our specialist team.' }}
                                </p>
                                @if($dept->head_of_department)
                                    <p class="text-xs text-blue-600 font-semibold mt-2">
                                        <span class="text-gray-400">Head:</span> {{ $dept->head_of_department }}
                                    </p>
                                @endif
                                @if($dept->location)
                                    <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                        <x-fas-eye class="w-3 h-3" />
                                        {{ $dept->location }}
                                    </p>
                                @endif
                            </div>
                            <a href="{{ route('website.contact') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors mt-auto">
                                Book Appointment
                                <x-fas-eye class="w-4 h-4" />
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-website.stats />
    <x-website.process />
    <x-website.cta />
    <x-website.footer />
</x-layouts.website>
