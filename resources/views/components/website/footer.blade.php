{{-- FOOTER --}}
<footer id="footer" class="bg-[#062C77] text-white">

    {{-- Newsletter bar --}}
    <div class="border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-lg font-bold text-white">Subscribe to Our Newsletter</h3>
                    <p class="text-sm text-blue-200 mt-1">Get the latest health tips and hospital news delivered to your inbox.</p>
                </div>
                <form class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto" onsubmit="return false;">
                    <input
                        type="email"
                        placeholder="Your email address"
                        class="w-full sm:flex-1 lg:w-72 bg-white/10 border border-white/20 text-white placeholder-white/40 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    >
                    <button type="submit" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-400 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/30 whitespace-nowrap">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main Footer Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10">

            {{-- Brand Column --}}
            <div class="lg:col-span-2 flex flex-col gap-5">
                {{-- Logo --}}
                @php
                    $siteLogo = \Modules\Settings\Models\Setting::where('key', 'site_logo')->value('value');
                    $appName = \Modules\Settings\Models\Setting::where('key', 'app_name')->value('value') ?: 'Ogechi Hospital';
                    $contactPhone = \Modules\Settings\Models\Setting::where('key', 'contact_phone')->value('value') ?: '+234 800 123 4567';
                    $contactEmail = \Modules\Settings\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@ogechihospital.com';
                    $contactAddress = \Modules\Settings\Models\Setting::where('key', 'contact_address')->value('value') ?: '12 Healthcare Avenue, Enugu, Nigeria';
                @endphp
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 w-fit group">
                    @if($siteLogo)
                        <img src="{{ Storage::url($siteLogo) }}" alt="{{ $appName }}" class="h-10 object-contain">
                    @else
                        <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:bg-blue-400 transition-colors">
                            <x-fas-hospital class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <span class="text-lg font-bold text-white block leading-none">{{ $appName }}</span>
                            <span class="text-[10px] font-medium text-blue-300 uppercase tracking-wider leading-none">Premium Healthcare</span>
                        </div>
                    @endif
                </a>

                <p class="text-sm text-blue-200 leading-relaxed max-w-xs">
                    Delivering world-class healthcare with compassion, innovation, and excellence. Your health is our highest priority, 24 hours a day, 7 days a week.
                </p>

                {{-- Contact Info --}}
                <div class="space-y-2.5">
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" class="flex items-center gap-2.5 text-sm text-blue-200 hover:text-white transition-colors group">
                        <div class="w-7 h-7 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                            <x-fas-phone-alt class="w-3.5 h-3.5" />
                        </div>
                        {{ $contactPhone }}
                    </a>
                    <a href="mailto:{{ $contactEmail }}" class="flex items-center gap-2.5 text-sm text-blue-200 hover:text-white transition-colors group">
                        <div class="w-7 h-7 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                            <x-fas-envelope class="w-3.5 h-3.5" />
                        </div>
                        {{ $contactEmail }}
                    </a>
                    <div class="flex items-center gap-2.5 text-sm text-blue-200">
                        <div class="w-7 h-7 bg-white/10 rounded-lg flex items-center justify-center">
                            <x-fas-map-marker-alt class="w-3.5 h-3.5" />
                        </div>
                        {{ $contactAddress }}
                    </div>
                </div>

                {{-- Social Icons --}}
                <div class="flex gap-2.5">
                    @foreach([
                        ['label' => 'Facebook',  'icon' => '<path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>'],
                        ['label' => 'Twitter',   'icon' => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>'],
                        ['label' => 'Instagram', 'icon' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" fill="none" stroke="currentColor" stroke-width="2"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>'],
                        ['label' => 'YouTube',   'icon' => '<path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"/>'],
                    ] as $social)
                        <a href="javascript:void(0)" aria-label="{{ $social['label'] }}" class="w-9 h-9 bg-white/10 hover:bg-blue-500 rounded-xl flex items-center justify-center text-blue-200 hover:text-white transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/30">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">{!! $social['icon'] !!}</svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="flex flex-col gap-4">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Quick Links</h4>
                <ul class="space-y-2.5">
                    @php
                        $quickLinks = [
                            'Home'        => route('home'),
                            'About Us'    => route('website.about'),
                            'Departments' => route('website.services'),
                            'Our Doctors' => route('website.doctors'),
                            'Blog'        => route('website.blog'),
                            'Contact Us'  => route('website.contact'),
                        ];
                    @endphp
                    @foreach($quickLinks as $label => $url)
                        <li>
                            <a href="{{ $url }}" class="text-sm text-blue-200 hover:text-white hover:pl-1 transition-all duration-200 flex items-center gap-1.5">
                                <x-fas-chevron-right class="w-3 h-3 text-blue-400" />
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Departments --}}
            <div class="flex flex-col gap-4">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Departments</h4>
                <ul class="space-y-2.5">
                    @foreach(['Cardiology', 'Orthopedics', 'Neurology', 'Dentistry', 'Pediatrics', 'Ophthalmology', 'Emergency Care'] as $dept)
                        <li>
                            <a href="{{ route('website.services') }}" class="text-sm text-blue-200 hover:text-white hover:pl-1 transition-all duration-200 flex items-center gap-1.5">
                                <x-fas-chevron-right class="w-3 h-3 text-blue-400" />
                                {{ $dept }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Opening Hours --}}
            <div class="flex flex-col gap-4">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Working Hours</h4>
                <div class="space-y-3">
                    @foreach([
                        ['days' => 'Monday – Friday', 'hours' => '8:00 AM – 10:00 PM'],
                        ['days' => 'Saturday',        'hours' => '9:00 AM – 8:00 PM'],
                        ['days' => 'Sunday',          'hours' => '10:00 AM – 6:00 PM'],
                    ] as $schedule)
                        <div class="border-b border-white/10 pb-3">
                            <p class="text-xs text-blue-300 font-medium mb-0.5">{{ $schedule['days'] }}</p>
                            <p class="text-sm text-white font-semibold">{{ $schedule['hours'] }}</p>
                        </div>
                    @endforeach
                    <div class="flex items-center gap-2 bg-green-500/10 border border-green-500/20 rounded-xl px-3 py-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse flex-shrink-0"></div>
                        <span class="text-xs text-green-300 font-semibold">Emergency: Open 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-blue-300">
                &copy; {{ date('Y') }} Ogechi Hospital. All rights reserved. Designed with ❤️ for better healthcare.
            </p>
            <div class="flex items-center gap-4">
                <a href="javascript:void(0)" class="text-xs text-blue-300 hover:text-white transition-colors">Privacy Policy</a>
                <span class="text-blue-600">•</span>
                <a href="javascript:void(0)" class="text-xs text-blue-300 hover:text-white transition-colors">Terms of Service</a>
                <span class="text-blue-600">•</span>
                <a href="javascript:void(0)" class="text-xs text-blue-300 hover:text-white transition-colors">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
