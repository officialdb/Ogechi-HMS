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
                $departments = [
                    ['no'=>'01','title'=>'Cardiology','desc'=>'Comprehensive heart care including diagnostics, interventional cardiology, heart failure management, and cardiac rehabilitation.','icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','color'=>'red'],
                    ['no'=>'02','title'=>'Orthopedics','desc'=>'Expert treatment for bone, joint, and muscle conditions including joint replacements, fracture care, sports injuries, and spine surgery.','icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','color'=>'blue'],
                    ['no'=>'03','title'=>'Neurology','desc'=>'Advanced diagnosis and treatment of brain and nervous system disorders including epilepsy, stroke, Parkinson\'s disease, and migraines.','icon'=>'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z','color'=>'violet'],
                    ['no'=>'04','title'=>'Dentistry','desc'=>'Complete oral healthcare from routine cleanings and fillings to orthodontics, implants, oral surgery, and cosmetic dentistry.','icon'=>'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'cyan'],
                    ['no'=>'05','title'=>'Pediatrics','desc'=>'Dedicated child healthcare covering newborn care, vaccinations, developmental assessments, and treatment of childhood illnesses.','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','color'=>'green'],
                    ['no'=>'06','title'=>'Ophthalmology','desc'=>'Full-spectrum eye care including vision testing, cataract surgery, glaucoma management, LASIK, and retinal treatments.','icon'=>'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z','color'=>'indigo'],
                    ['no'=>'07','title'=>'Dermatology','desc'=>'Expert skin, hair, and nail care covering acne, eczema, psoriasis, skin cancer screening, and advanced cosmetic procedures.','icon'=>'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01','color'=>'pink'],
                    ['no'=>'08','title'=>'Emergency Care','desc'=>'24/7 emergency department staffed with trauma-trained physicians and fully equipped to handle life-threatening conditions.','icon'=>'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'orange'],
                ];
                $colorMap = [
                    'red'    => ['bg'=>'bg-red-50',    'text'=>'text-red-600',    'hover'=>'group-hover:bg-red-600',    'num'=>'text-red-200'],
                    'blue'   => ['bg'=>'bg-blue-50',   'text'=>'text-blue-600',   'hover'=>'group-hover:bg-blue-600',   'num'=>'text-blue-200'],
                    'violet' => ['bg'=>'bg-violet-50', 'text'=>'text-violet-600', 'hover'=>'group-hover:bg-violet-600', 'num'=>'text-violet-200'],
                    'cyan'   => ['bg'=>'bg-cyan-50',   'text'=>'text-cyan-600',   'hover'=>'group-hover:bg-cyan-600',   'num'=>'text-cyan-200'],
                    'green'  => ['bg'=>'bg-green-50',  'text'=>'text-green-600',  'hover'=>'group-hover:bg-green-600',  'num'=>'text-green-200'],
                    'indigo' => ['bg'=>'bg-indigo-50', 'text'=>'text-indigo-600', 'hover'=>'group-hover:bg-indigo-600', 'num'=>'text-indigo-200'],
                    'pink'   => ['bg'=>'bg-pink-50',   'text'=>'text-pink-600',   'hover'=>'group-hover:bg-pink-600',   'num'=>'text-pink-200'],
                    'orange' => ['bg'=>'bg-orange-50', 'text'=>'text-orange-600', 'hover'=>'group-hover:bg-orange-600', 'num'=>'text-orange-200'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($departments as $dept)
                    @php $c = $colorMap[$dept['color']]; @endphp
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-blue-900/10 p-6 border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2 flex flex-col gap-4">
                        <span class="text-4xl font-black {{ $c['num'] }} opacity-40 leading-none select-none">{{ $dept['no'] }}</span>
                        <div class="{{ $c['bg'] }} {{ $c['text'] }} w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 {{ $c['hover'] }} group-hover:text-white group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $dept['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base mb-2 group-hover:text-blue-700 transition-colors">{{ $dept['title'] }}</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">{{ $dept['desc'] }}</p>
                        </div>
                        <a href="{{ route('website.contact') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors mt-auto">
                            Book Appointment
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-website.stats />
    <x-website.process />
    <x-website.cta />
    <x-website.footer />
</x-layouts.website>
