<x-layouts.website title="Our Doctors – Ogechi Hospital" metaDescription="Meet Ogechi Hospital's team of board-certified medical specialists committed to delivering expert, compassionate care across all departments.">

    <x-website.header-bar />
    <x-website.navbar />

    <x-website.page-hero
        title="Meet Our Doctors"
        subtitle="Our team of board-certified specialists brings decades of expertise and a shared passion for exceptional patient care."
        :breadcrumbs="[['label'=>'Home','route'=>'home'],['label'=>'Our Doctors']]"
        icon="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
    />

    {{-- Doctors Grid ---------------------------------------------- --}}
    <section class="py-20 lg:py-28 bg-[#F5F9FF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($doctors->isEmpty())
                {{-- Empty state --}}
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Doctors Listed Yet</h3>
                    <p class="text-gray-500 text-sm max-w-sm mx-auto">Our team profiles will appear here once added by the admin. Please check back soon.</p>
                </div>
            @else
                @php
                    $gradients = [
                        'from-blue-400 to-blue-600',
                        'from-violet-400 to-violet-600',
                        'from-cyan-400 to-cyan-600',
                        'from-emerald-400 to-emerald-600',
                        'from-rose-400 to-rose-600',
                        'from-sky-400 to-sky-600',
                        'from-purple-400 to-purple-600',
                        'from-teal-400 to-teal-600',
                        'from-orange-400 to-orange-600',
                        'from-pink-400 to-pink-600',
                    ];
                    $skins = ['#F59E0B','#FCD34D','#FBBF24','#F97316'];
                    $coats = ['#1E40AF','#5B21B6','#0E7490','#065F46','#9F1239','#0C4A6E','#4C1D95','#134E4A'];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($doctors as $i => $doctor)
                        @php
                            $grad     = $gradients[$i % count($gradients)];
                            $skinHex  = $skins[$i % count($skins)];
                            $coatHex  = $coats[$i % count($coats)];
                            $rectFill = $coatHex . '80';
                            $initials = strtoupper(substr($doctor->first_name, 0, 1));
                            $yearsExp = $doctor->created_at ? now()->diffInYears($doctor->created_at) : null;
                        @endphp
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-blue-900/10 overflow-hidden border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2">
                            {{-- Illustrated Avatar Card --}}
                            <div class="relative h-56 bg-gradient-to-br {{ $grad }} overflow-hidden">
                                <svg viewBox="0 0 200 224" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="200" height="224" fill="{{ $rectFill }}"/>
                                    <circle cx="100" cy="270" r="130" fill="rgba(255,255,255,0.08)"/>
                                    <ellipse cx="100" cy="190" rx="65" ry="80" fill="{{ $coatHex }}"/>
                                    <rect x="70" y="155" width="60" height="85" rx="5" fill="white" opacity="0.15"/>
                                    <circle cx="100" cy="115" r="38" fill="{{ $skinHex }}"/>
                                    <ellipse cx="100" cy="83" rx="38" ry="20" fill="#1E3A5F"/>
                                    <rect x="88" y="148" width="24" height="20" rx="4" fill="{{ $skinHex }}"/>
                                    <path d="M82 168 Q72 195 77 210 Q82 225 100 228 Q118 225 123 210 Q128 195 118 168" fill="none" stroke="rgba(200,200,255,0.6)" stroke-width="3" stroke-linecap="round"/>
                                    <rect x="86" y="175" width="28" height="10" rx="3" fill="white" opacity="0.5"/>
                                    {{-- Initials badge --}}
                                    <circle cx="100" cy="115" r="22" fill="rgba(255,255,255,0.25)"/>
                                    <text x="100" y="121" text-anchor="middle" font-family="sans-serif" font-size="18" font-weight="bold" fill="white">{{ $initials }}</text>
                                </svg>

                                {{-- Department badge --}}
                                @if($doctor->department)
                                    <div class="absolute top-3 left-3 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-2.5 py-1 rounded-full border border-white/30 truncate max-w-[120px]">
                                        {{ $doctor->department->name }}
                                    </div>
                                @endif

                                {{-- Active indicator --}}
                                <div class="absolute top-3 right-3 flex items-center gap-1 bg-emerald-500/20 backdrop-blur-sm text-white text-xs font-semibold px-2 py-1 rounded-full border border-emerald-300/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Active
                                </div>
                            </div>

                            <div class="p-5 text-center">
                                <h3 class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition-colors">{{ $doctor->full_name }}</h3>
                                <p class="text-blue-600 text-xs font-semibold mt-1">{{ $doctor->specialization }}</p>
                                @if($doctor->bio)
                                    <p class="text-gray-400 text-xs mt-2 leading-relaxed line-clamp-2">{{ $doctor->bio }}</p>
                                @endif
                                <div class="flex justify-center gap-0.5 mt-3">
                                    @for($s=0;$s<5;$s++)
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
            @endif
        </div>
    </section>

    <x-website.testimonials />
    <x-website.cta />
    <x-website.footer />
</x-layouts.website>
