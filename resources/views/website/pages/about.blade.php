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
                        About <span class="text-gradient">Ogechi Hospital</span>
                    </h2>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        At Ogechi Hospital, we are dedicated to delivering quality healthcare services built on compassion, professionalism, integrity, and patient-centered care. We understand that every patient deserves timely medical attention, accurate diagnosis, and effective treatment in a safe and supportive environment. Our commitment is to provide healthcare services that improve lives, strengthen families, and support the wellbeing of the community we serve.
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        Since our establishment, Ogechi Hospital has remained focused on creating a healthcare experience where patients feel valued, respected, and cared for at every stage of treatment. We combine medical expertise with a compassionate approach to ensure that every individual who walks through our doors receives the highest standard of care possible.
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        Our hospital provides a wide range of healthcare services including general medical consultations, maternity care, pediatric services, laboratory investigations, emergency treatment, inpatient and outpatient care, and preventive health services. We are committed to using modern medical practices and reliable diagnostic support to help patients receive accurate and effective treatment.
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        At Ogechi Hospital, we believe healthcare goes beyond treating illness. We focus on preventive care, health education, and long-term wellness to help individuals and families live healthier lives. Through continuous improvement, professional development, and dedication to excellence, we strive to maintain a healthcare environment that patients can trust with confidence.
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        Our medical professionals and healthcare staff work together to provide compassionate care tailored to the unique needs of every patient. We are driven by a strong sense of responsibility to ensure comfort, safety, dignity, and confidentiality in every interaction.
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        As a healthcare provider, our goal is to continue building strong relationships within the community by offering accessible, affordable, and dependable medical services. We remain committed to making quality healthcare available to everyone while upholding the values of integrity, empathy, accountability, and excellence in all we do.
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
                                <x-fas-eye class="w-5 h-5 text-white" />
                            </div>
                            <h3 class="font-bold text-gray-900">Our Mission</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">To provide accessible, affordable, and high-quality healthcare services through compassionate patient care, professional medical excellence, accurate diagnosis, and a commitment to improving the health and wellbeing of individuals, families, and the community.</p>
                    </div>
                    {{-- Vision --}}
                    <div class="bg-blue-600 rounded-2xl p-6 text-white hover:shadow-xl hover:shadow-blue-600/30 transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <x-fas-eye class="w-5 h-5 text-white" />
                            </div>
                            <h3 class="font-bold text-white">Our Vision</h3>
                        </div>
                        <p class="text-sm text-blue-100 leading-relaxed">To be a trusted and leading healthcare institution recognized for exceptional patient care, medical excellence, innovation, and continuous commitment to healthier communities through reliable and compassionate healthcare services.</p>
                    </div>
                    {{-- Values --}}
                    <div class="bg-[#F5F9FF] rounded-2xl p-6 border border-blue-50 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center">
                                <x-fas-cog class="w-5 h-5 text-white" />
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
