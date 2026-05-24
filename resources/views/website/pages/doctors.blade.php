<x-layouts.website title="Our Doctors – Ogechi Hospital" metaDescription="Meet Ogechi Hospital's team of board-certified medical specialists committed to delivering expert, compassionate care across all departments.">

    <x-website.header-bar />
    <x-website.navbar />

    <x-website.page-hero
        title="Meet Our Doctors"
        subtitle="Our team of 410+ board-certified specialists brings decades of expertise and a shared passion for exceptional patient care."
        :breadcrumbs="[['label'=>'Home','route'=>'home'],['label'=>'Our Doctors']]"
        icon="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
    />

    {{-- Doctors Grid ---------------------------------------------- --}}
    <section class="py-20 lg:py-28 bg-[#F5F9FF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Filter tabs --}}
            <div
                x-data="{ active: 'all' }"
                class="flex flex-wrap gap-2 justify-center mb-12"
            >
                @foreach(['all'=>'All Doctors','cardiology'=>'Cardiology','neurology'=>'Neurology','orthopedics'=>'Orthopedics','dentistry'=>'Dentistry','general'=>'General'] as $key => $label)
                    <button
                        @click="active = '{{ $key }}'"
                        :class="active === '{{ $key }}' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-300 hover:text-blue-600'"
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200"
                    >{{ $label }}</button>
                @endforeach
            </div>

            @php
                $doctors = [
                    ['name'=>'Dr. Samuel Okonkwo',   'specialty'=>'Cardiologist',        'exp'=>'15 yrs','dept'=>'cardiology','grad'=>'from-blue-400 to-blue-600',   'skin'=>'#F59E0B','coat'=>'#1E40AF'],
                    ['name'=>'Dr. Amaka Nwachukwu',  'specialty'=>'Neurologist',         'exp'=>'12 yrs','dept'=>'neurology', 'grad'=>'from-violet-400 to-violet-600','skin'=>'#FCD34D','coat'=>'#5B21B6'],
                    ['name'=>'Dr. Emeka Obi',         'specialty'=>'Orthopedic Surgeon',  'exp'=>'18 yrs','dept'=>'orthopedics','grad'=>'from-cyan-400 to-cyan-600',  'skin'=>'#F59E0B','coat'=>'#0E7490'],
                    ['name'=>'Dr. Chioma Ezeh',       'specialty'=>'Dentist',             'exp'=>'10 yrs','dept'=>'dentistry', 'grad'=>'from-emerald-400 to-emerald-600','skin'=>'#FBBF24','coat'=>'#065F46'],
                    ['name'=>'Dr. Ifeanyi Eze',       'specialty'=>'General Practitioner','exp'=>'9 yrs', 'dept'=>'general',   'grad'=>'from-rose-400 to-rose-600',   'skin'=>'#F59E0B','coat'=>'#9F1239'],
                    ['name'=>'Dr. Ngozi Okafor',      'specialty'=>'Cardiologist',        'exp'=>'14 yrs','dept'=>'cardiology','grad'=>'from-sky-400 to-sky-600',     'skin'=>'#FBBF24','coat'=>'#0C4A6E'],
                    ['name'=>'Dr. Chukwuemeka Agu',  'specialty'=>'Neurologist',         'exp'=>'11 yrs','dept'=>'neurology', 'grad'=>'from-purple-400 to-purple-600','skin'=>'#F59E0B','coat'=>'#4C1D95'],
                    ['name'=>'Dr. Adaeze Obiora',     'specialty'=>'Orthopedic Surgeon',  'exp'=>'16 yrs','dept'=>'orthopedics','grad'=>'from-teal-400 to-teal-600',  'skin'=>'#FCD34D','coat'=>'#134E4A'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($doctors as $doctor)
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-blue-900/10 overflow-hidden border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2">
                        <div class="relative h-56 bg-gradient-to-br {{ $doctor['grad'] }} overflow-hidden">
                            <svg viewBox="0 0 200 224" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                            @php
                                $coatHex = $doctor['coat'];
                                $rectFill = $coatHex . '80';
                            @endphp
                                <rect width="200" height="224" fill="{{ $rectFill }}"/>
                                <circle cx="100" cy="270" r="130" fill="rgba(255,255,255,0.08)"/>
                                <ellipse cx="100" cy="190" rx="65" ry="80" fill="{{ $doctor['coat'] }}"/>
                                <rect x="70" y="155" width="60" height="85" rx="5" fill="white" opacity="0.15"/>
                                <circle cx="100" cy="115" r="38" fill="{{ $doctor['skin'] }}"/>
                                <ellipse cx="100" cy="83" rx="38" ry="20" fill="#1E3A5F"/>
                                <rect x="88" y="148" width="24" height="20" rx="4" fill="{{ $doctor['skin'] }}"/>
                                <path d="M82 168 Q72 195 77 210 Q82 225 100 228 Q118 225 123 210 Q128 195 118 168" fill="none" stroke="rgba(200,200,255,0.6)" stroke-width="3" stroke-linecap="round"/>
                                <rect x="86" y="175" width="28" height="10" rx="3" fill="white" opacity="0.5"/>
                            </svg>
                            <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div class="flex gap-2">
                                    @foreach(['M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z','M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z','M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 4m-2 0a2 2 0 104 0 2 2 0 10-4 0'] as $path)
                                        <a href="#" class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors shadow-md">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-2.5 py-1 rounded-full border border-white/30">{{ $doctor['exp'] }} exp</div>
                        </div>
                        <div class="p-5 text-center">
                            <h3 class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition-colors">{{ $doctor['name'] }}</h3>
                            <p class="text-blue-600 text-xs font-semibold mt-1">{{ $doctor['specialty'] }}</p>
                            <div class="flex justify-center gap-0.5 mt-2">
                                @for($i=0;$i<5;$i++)
                                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <a href="{{ route('website.contact') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                Book Appointment <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-website.testimonials />
    <x-website.cta />
    <x-website.footer />
</x-layouts.website>
