<x-layouts.website title="About Us – Ogechi Hospital" metaDescription="Learn about Ogechi Hospital's history, mission, values, and the world-class medical team committed to delivering premium healthcare in Nigeria.">

    <x-website.header-bar />
    <x-website.navbar />

    {{-- Page Hero --}}
    <x-website.page-hero
        title="About Ogechi Hospital"
        subtitle="Delivering compassionate, world-class healthcare since 2008. Meet the people and values behind our commitment to your wellbeing."
        :breadcrumbs="[['label'=>'Home','route'=>'home'],['label'=>'About Us']]"
        icon="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
    />

    {{-- Mission & Vision --------------------------------------------------- --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-4">Our Story</div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-5">
                        We Are Best Professional<br>In <span class="text-gradient">Medical Sectors</span>
                    </h2>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        Founded in 2008, Ogechi Hospital began with a simple but powerful mission: to make premium, compassionate healthcare accessible to every Nigerian. What started as a small clinic in Enugu has grown into one of Nigeria's most respected full-service hospitals.
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Today, we are home to over 410 specialist doctors, nurses, and support staff — united by our commitment to clinical excellence, patient dignity, and continuous innovation in medical practice.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach([
                            ['value'=>'17+', 'label'=>'Years of Excellence'],
                            ['value'=>'410+','label'=>'Expert Specialists'],
                            ['value'=>'25k+','label'=>'Patients Served'],
                            ['value'=>'33',  'label'=>'Departments'],
                        ] as $stat)
                            <div class="bg-[#F5F9FF] rounded-2xl p-4 text-center border border-blue-50">
                                <p class="text-2xl font-black text-blue-600">{{ $stat['value'] }}</p>
                                <p class="text-xs text-gray-500 font-medium mt-1">{{ $stat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="space-y-4">
                    {{-- Mission --}}
                    <div class="bg-[#F5F9FF] rounded-2xl p-6 border border-blue-50 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <h3 class="font-bold text-gray-900">Our Mission</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">To provide accessible, compassionate, and evidence-based healthcare that improves the quality of life for every patient we serve — treating not just the condition, but the whole person.</p>
                    </div>
                    {{-- Vision --}}
                    <div class="bg-blue-600 rounded-2xl p-6 text-white hover:shadow-xl hover:shadow-blue-600/30 transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </div>
                            <h3 class="font-bold text-white">Our Vision</h3>
                        </div>
                        <p class="text-sm text-blue-100 leading-relaxed">To be West Africa's most trusted healthcare institution — setting the standard for clinical excellence, patient experience, and medical innovation by 2030.</p>
                    </div>
                    {{-- Values --}}
                    <div class="bg-[#F5F9FF] rounded-2xl p-6 border border-blue-50 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h3 class="font-bold text-gray-900">Our Values</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach(['Compassion','Excellence','Integrity','Innovation','Teamwork','Respect'] as $val)
                                <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                    <div class="w-1.5 h-1.5 bg-blue-600 rounded-full"></div>
                                    {{ $val }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Component (image + opening hours) --}}
    <x-website.about />

    {{-- Stats --}}
    <x-website.stats />

    {{-- Process --}}
    <x-website.process />

    {{-- CTA --}}
    <x-website.cta />

    <x-website.footer />
</x-layouts.website>
