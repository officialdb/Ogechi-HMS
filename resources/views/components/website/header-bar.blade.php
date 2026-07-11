{{-- Website Top Header Bar --}}
<div class="bg-white border-b border-gray-100 py-2 px-4 hidden lg:block">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        {{-- Logo --}}
        @php
            $siteLogo = \Modules\Settings\Models\Setting::where('key', 'site_logo')->value('value');
            $appName = \Modules\Settings\Models\Setting::where('key', 'app_name')->value('value') ?: 'Ogechi Hospital';
            $contactPhone = \Modules\Settings\Models\Setting::where('key', 'contact_phone')->value('value') ?: '+234 800 123 4567';
            $contactEmail = \Modules\Settings\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@ogechihospital.com';
        @endphp
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
            @if($siteLogo)
                <img src="{{ Storage::url($siteLogo) }}" alt="{{ $appName }}" class="h-10 object-contain">
            @else
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-md shadow-blue-600/30 group-hover:bg-blue-700 transition-colors">
                    <x-fas-hospital class="w-5 h-5 text-white" />
                </div>
                <div>
                    <span class="text-lg font-bold text-gray-900 leading-none">{{ explode(' ', $appName)[0] }}</span>
                    <span class="block text-[10px] font-medium text-blue-600 uppercase tracking-wider leading-none">{{ implode(' ', array_slice(explode(' ', $appName), 1)) }}</span>
                </div>
            @endif
        </a>

        {{-- Contact Info --}}
        <div class="flex items-center gap-8">
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                    <x-fas-phone-alt class="w-4 h-4 text-blue-600" />
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wide leading-none mb-0.5">Phone Number</p>
                    <p class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors leading-none">{{ $contactPhone }}</p>
                </div>
            </a>

            <a href="mailto:{{ $contactEmail }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                    <x-fas-envelope class="w-4 h-4 text-blue-600" />
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wide leading-none mb-0.5">Email Address</p>
                    <p class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors leading-none">{{ $contactEmail }}</p>
                </div>
            </a>


        </div>
    </div>
</div>
