<x-layouts.website title="Contact Us – Ogechi Hospital" metaDescription="Get in touch with Ogechi Hospital. Book an appointment, find our location, or reach our 24/7 emergency line. We are always here for you.">

    <x-website.header-bar />
    <x-website.navbar />

    <x-website.page-hero
        title="Contact Us"
        subtitle="We are always here for you — whether you need to book an appointment, ask a question, or reach our emergency team."
        :breadcrumbs="[['label'=>'Home','route'=>'home'],['label'=>'Contact']]"
        icon="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
    />

    {{-- Contact Cards Row -------------------------------------------------- --}}
    <section class="py-14 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                    $contactEmail = \Modules\Settings\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@ogechihospital.com';
                    $contactPhone = \Modules\Settings\Models\Setting::where('key', 'contact_phone')->value('value') ?: '+234 800 123 4567';
                    $contactAddress = \Modules\Settings\Models\Setting::where('key', 'contact_address')->value('value') ?: '12 Healthcare Avenue, Enugu, Nigeria';
                    $googleMapsUrl = \Modules\Settings\Models\Setting::where('key', 'google_maps_url')->value('value');
                    
                    $addressParts = explode(',', $contactAddress);
                    $addressMain = trim($addressParts[0] ?? $contactAddress);
                    $addressSub = count($addressParts) > 1 ? trim(implode(',', array_slice($addressParts, 1))) : 'Visit Us';

                    $contactCards = [
                        [
                            'icon'  => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                            'label' => 'Phone',
                            'value' => $contactPhone,
                            'sub'   => 'Mon–Fri, 8AM–10PM',
                            'color' => 'bg-blue-600',
                            'href'  => 'tel:' . preg_replace('/[^0-9+]/', '', $contactPhone),
                        ],
                        [
                            'icon'  => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                            'label' => 'Email',
                            'value' => $contactEmail,
                            'sub'   => 'Reply within 24 hours',
                            'color' => 'bg-indigo-600',
                            'href'  => 'mailto:' . $contactEmail,
                        ],
                        [
                            'icon'  => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                            'label' => 'Address',
                            'value' => $addressMain,
                            'sub'   => $addressSub,
                            'color' => 'bg-violet-600',
                            'href'  => '#map',
                        ],
                        [
                            'icon'  => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                            'label' => 'Emergency',
                            'value' => '+234 800 911 0000',
                            'sub'   => 'Available 24 / 7',
                            'color' => 'bg-red-600',
                            'href'  => 'tel:+2348009110000',
                        ],
                    ];
                @endphp

                @foreach($contactCards as $card)
                    <a href="{{ $card['href'] }}"
                       class="group flex flex-col items-center text-center gap-3 bg-[#F5F9FF] hover:bg-white rounded-2xl p-6 border border-blue-50 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-900/10 transition-all duration-300 hover:-translate-y-1">
                        <div class="{{ $card['color'] }} w-13 h-13 w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-900/20 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">{{ $card['label'] }}</p>
                            <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition-colors">{{ $card['value'] }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $card['sub'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact Form + Info ------------------------------------------------ --}}
    <section class="py-16 lg:py-24 bg-[#F5F9FF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

                {{-- Left: Form (3 cols) --}}
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="mb-7">
                            <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-3">Send a Message</div>
                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">Book an Appointment<br>or Get in Touch</h2>
                            <p class="text-sm text-gray-500 mt-2 leading-relaxed">Fill the form below and our team will get back to you within 1 business hour during working hours.</p>
                        </div>

                        <form
                            x-data="{
                                submitted: false,
                                loading: false,
                                errorMsg: '',
                                formData: {
                                    patient_status: 'new',
                                    name: '',
                                    email: '',
                                    phone: '',
                                    doctor_id: '',
                                    appointment_date: '',
                                    appointment_time: '',
                                    subject: '',
                                    message: ''
                                },
                                async submit() {
                                    this.loading = true;
                                    this.errorMsg = '';
                                    try {
                                        const res = await fetch('{{ route('website.book') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify(this.formData)
                                        });
                                        const data = await res.json();
                                        if (!res.ok) {
                                            this.errorMsg = data.message || 'An error occurred. Please check your details.';
                                        } else {
                                            this.submitted = true;
                                        }
                                    } catch (err) {
                                        this.errorMsg = 'A network error occurred. Please try again later.';
                                    } finally {
                                        this.loading = false;
                                    }
                                }
                            }"
                            @submit.prevent="submit()"
                            class="space-y-4"
                            novalidate
                        >
                            {{-- Success state --}}
                            <div x-show="submitted" x-transition class="bg-green-50 border border-green-200 rounded-2xl p-5 text-center" style="display:none;">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-green-800 text-sm">Appointment Booked Successfully!</h3>
                                <p class="text-green-600 text-xs mt-1">We will contact you shortly to confirm your slot. Thank you!</p>
                            </div>

                            {{-- Error state --}}
                            <div x-show="errorMsg !== ''" x-transition class="bg-red-50 border border-red-200 rounded-2xl p-4 text-sm text-red-600 font-medium" style="display:none;" x-text="errorMsg">
                            </div>

                            <div x-show="!submitted" class="space-y-4">
                                {{-- Patient Status --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">Are you a new or returning patient?</label>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" x-model="formData.patient_status" value="new" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="text-sm text-gray-700 font-medium">New Patient</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" x-model="formData.patient_status" value="returning" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="text-sm text-gray-700 font-medium">Returning Patient</span>
                                        </label>
                                    </div>
                                </div>
                                {{-- Name & Email --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="contact_name">Full Name <span class="text-red-500">*</span></label>
                                        <input
                                            id="contact_name"
                                            type="text"
                                            x-model="formData.name"
                                            placeholder="e.g. Amaka Okafor"
                                            required
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors"
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="contact_email">Email Address <span class="text-red-500">*</span></label>
                                        <input
                                            id="contact_email"
                                            type="email"
                                            x-model="formData.email"
                                            placeholder="you@example.com"
                                            required
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors"
                                        >
                                    </div>
                                </div>

                                {{-- Phone & Subject --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="contact_phone">Phone Number <span class="text-red-500">*</span></label>
                                        <input
                                            id="contact_phone"
                                            type="tel"
                                            x-model="formData.phone"
                                            required
                                            placeholder="+234 800 000 0000"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors"
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="contact_subject">Reason <span class="text-red-500">*</span></label>
                                        <select
                                            id="contact_subject"
                                            x-model="formData.subject"
                                            required
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors"
                                        >
                                            <option value="">Select a reason</option>
                                            <option>Book an Appointment</option>
                                            <option>General Enquiry</option>
                                            <option>Emergency Consultation</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Doctor --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="contact_doctor">Select Doctor <span class="text-red-500">*</span></label>
                                    <select
                                        id="contact_doctor"
                                        x-model="formData.doctor_id"
                                        required
                                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors"
                                    >
                                        <option value="">Select a specialist</option>
                                        @foreach($doctors ?? [] as $doc)
                                            <option value="{{ $doc->id }}">{{ $doc->user->name ?? 'Dr. '.$doc->first_name.' '.$doc->last_name }} ({{ $doc->department->name ?? 'General' }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Date & Time --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="contact_date">Preferred Date <span class="text-red-500">*</span></label>
                                        <input
                                            id="contact_date"
                                            type="date"
                                            x-model="formData.appointment_date"
                                            required
                                            min="{{ date('Y-m-d') }}"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors"
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="contact_time">Preferred Time <span class="text-red-500">*</span></label>
                                        <input
                                            id="contact_time"
                                            type="time"
                                            x-model="formData.appointment_time"
                                            required
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors"
                                        >
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="contact_message">Additional Notes <span class="text-red-500">*</span></label>
                                    <textarea
                                        id="contact_message"
                                        rows="4"
                                        x-model="formData.message"
                                        placeholder="Describe your symptoms, questions, or appointment details..."
                                        required
                                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors resize-none"
                                    ></textarea>
                                </div>

                                {{-- Submit --}}
                                <button
                                    type="submit"
                                    :disabled="loading"
                                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-bold text-sm py-3.5 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-600/30 flex items-center justify-center gap-2"
                                >
                                    <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    <span x-text="loading ? 'Sending...' : 'Send Message & Book Appointment'"></span>
                                </button>

                                <p class="text-xs text-gray-400 text-center leading-relaxed">
                                    🔒 Your information is secure and will never be shared with third parties.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right: Info Panel (2 cols) --}}
                <div class="lg:col-span-2 space-y-5">

                    {{-- Opening Hours --}}
                    <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-xl shadow-blue-600/25">
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-base">Opening Hours</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach([
                                ['days'=>'Monday – Friday',   'hours'=>'8:00 AM – 10:00 PM', 'open'=>true],
                                ['days'=>'Saturday',          'hours'=>'9:00 AM – 8:00 PM',  'open'=>true],
                                ['days'=>'Sunday',            'hours'=>'10:00 AM – 6:00 PM', 'open'=>true],
                                ['days'=>'Public Holidays',   'hours'=>'Emergency Only',     'open'=>false],
                            ] as $h)
                                <div class="flex justify-between items-center pb-3 border-b border-white/15 last:border-0">
                                    <span class="text-sm text-blue-100 font-medium">{{ $h['days'] }}</span>
                                    <span class="text-sm font-bold text-white bg-white/15 px-3 py-1 rounded-lg">{{ $h['hours'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 flex items-center gap-2 bg-green-500/15 border border-green-400/25 rounded-xl px-3 py-2.5">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse flex-shrink-0"></div>
                            <span class="text-xs text-green-200 font-semibold">Emergency Department: Open 24/7</span>
                        </div>
                    </div>

                    {{-- Quick info cards --}}
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-4">
                        <h3 class="font-bold text-gray-900 text-sm">Why Choose Us</h3>
                        @foreach([
                            ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','text'=>'Board-certified specialists in every department','color'=>'text-blue-600 bg-blue-50'],
                            ['icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','text'=>'Same-day appointments available','color'=>'text-green-600 bg-green-50'],
                            ['icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','text'=>'24/7 emergency care and support','color'=>'text-red-600 bg-red-50'],
                            ['icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','text'=>'Transparent billing and insurance support','color'=>'text-violet-600 bg-violet-50'],
                        ] as $item)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 {{ $item['color'] }} rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed">{{ $item['text'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Social Media --}}
                    <div class="bg-[#F5F9FF] rounded-2xl p-5 border border-blue-50">
                        <h3 class="font-bold text-gray-900 text-sm mb-4">Follow Us</h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach([
                                ['label'=>'Facebook','color'=>'bg-blue-600 hover:bg-blue-700','sub'=>'@ogechihospital','icon'=>'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
                                ['label'=>'Instagram','color'=>'bg-gradient-to-br from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600','sub'=>'@ogechi_hospital','icon'=>'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'],
                                ['label'=>'Twitter/X','color'=>'bg-gray-900 hover:bg-gray-800','sub'=>'@OgechiHospital','icon'=>'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
                                ['label'=>'YouTube','color'=>'bg-red-600 hover:bg-red-700','sub'=>'Ogechi Hospital','icon'=>'M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z M9.75 15.02 15.5 12 9.75 8.98 9.75 15.02'],
                            ] as $s)
                                <a href="#" class="{{ $s['color'] }} text-white rounded-xl p-3 flex items-center gap-2.5 transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $s['icon'] }}"/></svg>
                                    <div>
                                        <p class="text-xs font-bold leading-none">{{ $s['label'] }}</p>
                                        <p class="text-[10px] opacity-70 mt-0.5 leading-none">{{ $s['sub'] }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Map Section -------------------------------------------------------- --}}
    <section id="map" class="bg-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-3">Find Us</div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">Our <span class="text-gradient">Location</span></h2>
            </div>
            {{-- Map placeholder (styled) or embedded iframe --}}
            @if($googleMapsUrl)
                @php
                    $mapSrc = $googleMapsUrl;
                    if (preg_match('/src="([^"]+)"/', $googleMapsUrl, $matches)) {
                        $mapSrc = $matches[1];
                    }
                @endphp
                <div class="relative rounded-2xl overflow-hidden shadow-lg border border-gray-100 h-[400px]">
                    <iframe src="{{ $mapSrc }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            @else
                <div class="relative rounded-2xl overflow-hidden shadow-lg border border-gray-100" style="height: 400px; background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);">
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-4">
                        {{-- Decorative map grid --}}
                        <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(#3B82F6 1px, transparent 1px), linear-gradient(90deg, #3B82F6 1px, transparent 1px); background-size: 40px 40px;"></div>

                        {{-- Pin --}}
                        <div class="relative z-10 flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center shadow-2xl shadow-blue-600/40 animate-bounce">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="bg-white rounded-2xl shadow-xl px-6 py-3 text-center border border-blue-100">
                                <p class="font-bold text-gray-900 text-sm">{{ \Modules\Settings\Models\Setting::where('key', 'app_name')->value('value') ?: 'Ogechi Hospital' }}</p>
                                <p class="text-blue-600 text-xs font-medium mt-0.5">{{ $contactAddress }}</p>
                                <a href="https://maps.google.com/?q={{ urlencode($contactAddress) }}" target="_blank" rel="noopener noreferrer"
                                   class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                    Open in Google Maps
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <x-website.footer />
</x-layouts.website>
