<x-admin-layout title="System Settings">
<div class="max-w-6xl mx-auto space-y-6" x-data="{ 
    activeTab: 'general',
    isSaving: false,
    showToast: false,
    toastMessage: '',
    async saveSettings(event) {
        this.isSaving = true;
        let form = event.target;
        let formData = new FormData(form);
        try {
            let response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            let data = await response.json();
            if (response.ok && data.success) {
                this.toastMessage = data.message || 'Settings saved successfully!';
            } else {
                this.toastMessage = data.message || 'Error saving settings.';
            }
        } catch (error) {
            this.toastMessage = 'Error saving settings.';
        }
        this.isSaving = false;
        this.showToast = true;
        setTimeout(() => this.showToast = false, 3000);
    }
}">
    
    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">System Settings</h1>
            <p class="text-sm text-slate-500 mt-1">Manage application configuration, branding, and core preferences.</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- ── SIDEBAR TABS ─────────────────────────────── --}}
<div class="w-full lg:w-64 shrink-0">
    <nav class="flex lg:flex-col gap-2 overflow-x-auto lg:overflow-visible pb-2 lg:pb-0" aria-label="Tabs">
        {{-- General (System-wide configurations) --}}
        <button @click="activeTab = 'general'" :class="{ 'bg-white shadow-sm text-blue-600 font-bold border-slate-200': activeTab === 'general', 'text-slate-500 hover:bg-slate-50 border-transparent': activeTab !== 'general' }" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl border transition-all whitespace-nowrap lg:whitespace-normal">
            <x-fas-sliders class="w-5 h-5" />
            General Settings
        </button>
        
        {{-- Branding (Logo and Visual Identity) --}}
        <button @click="activeTab = 'branding'" :class="{ 'bg-white shadow-sm text-blue-600 font-bold border-slate-200': activeTab === 'branding', 'text-slate-500 hover:bg-slate-50 border-transparent': activeTab !== 'branding' }" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl border transition-all whitespace-nowrap lg:whitespace-normal">
            <x-fas-image-portrait class="w-5 h-5" />
            Logo & Branding
        </button>

        {{-- Contact & Location (Physical Addresses and Forms) --}}
        <button @click="activeTab = 'contact'" :class="{ 'bg-white shadow-sm text-blue-600 font-bold border-slate-200': activeTab === 'contact', 'text-slate-500 hover:bg-slate-50 border-transparent': activeTab !== 'contact' }" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl border transition-all whitespace-nowrap lg:whitespace-normal">
            <x-fas-map-location-dot class="w-5 h-5" />
            Contact & Contact
        </button>

        {{-- Mail Configuration (SMTP, Templates, etc.) --}}
        <button @click="activeTab = 'mail'" :class="{ 'bg-white shadow-sm text-blue-600 font-bold border-slate-200': activeTab === 'mail', 'text-slate-500 hover:bg-slate-50 border-transparent': activeTab !== 'mail' }" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl border transition-all whitespace-nowrap lg:whitespace-normal">
            <x-fas-envelope-open-text class="w-5 h-5" />
            SMTP & Email
        </button>

        {{-- SEO & Meta (Search Engine Metadata) --}}
        <button @click="activeTab = 'seo'" :class="{ 'bg-white shadow-sm text-blue-600 font-bold border-slate-200': activeTab === 'seo', 'text-slate-500 hover:bg-slate-50 border-transparent': activeTab !== 'seo' }" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl border transition-all whitespace-nowrap lg:whitespace-normal">
            <x-fas-chart-line class="w-5 h-5" />
            SEO & Meta
        </button>

        {{-- Social Media (Platform Links and OpenGraph) --}}
        <button @click="activeTab = 'social'" :class="{ 'bg-white shadow-sm text-blue-600 font-bold border-slate-200': activeTab === 'social', 'text-slate-500 hover:bg-slate-50 border-transparent': activeTab !== 'social' }" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl border transition-all whitespace-nowrap lg:whitespace-normal">
            <x-fas-hashtag class="w-5 h-5" />
            Social Media
        </button>

        {{-- System Preferences (Deep Maintenance/Wrench) --}}
        <button @click="activeTab = 'preferences'" :class="{ 'bg-white shadow-sm text-blue-600 font-bold border-slate-200': activeTab === 'preferences', 'text-slate-500 hover:bg-slate-50 border-transparent': activeTab !== 'preferences' }" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl border transition-all whitespace-nowrap lg:whitespace-normal">
            <x-fas-wrench class="w-5 h-5" />
            System Preferences
        </button>

        {{-- Homepage Content (Editing the front page) --}}
        <button @click="activeTab = 'homepage'" :class="{ 'bg-white shadow-sm text-blue-600 font-bold border-slate-200': activeTab === 'homepage', 'text-slate-500 hover:bg-slate-50 border-transparent': activeTab !== 'homepage' }" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl border transition-all whitespace-nowrap lg:whitespace-normal">
            <x-fas-brush class="w-5 h-5" />
            Homepage Content
        </button>
    </nav>
</div>

        {{-- ── FORM CONTENT ─────────────────────────────── --}}
        <div class="flex-1">
            <form @submit.prevent="saveSettings" action="{{ route('modules.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                @csrf

                {{-- Tab: General --}}
                <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <h2 class="text-lg font-black text-slate-900 mb-6 pb-4 border-b border-slate-100">General Settings</h2>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Application Name</label>
                            <input type="text" name="app_name" value="{{ $settings['app_name'] ?? config('app.name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium">
                            <p class="text-xs text-slate-500 mt-2">This is the global name of the hospital or application.</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Time Zone</label>
                                <select name="timezone" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium appearance-none">
                                    <option value="UTC" {{ ($settings['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="America/New_York" {{ ($settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                                    <option value="Europe/London" {{ ($settings['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
                                    <option value="Africa/Lagos" {{ ($settings['timezone'] ?? '') == 'Africa/Lagos' ? 'selected' : '' }}>Africa/Lagos (WAT)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Currency Symbol</label>
                                <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '$' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab: Branding --}}
                <div x-show="activeTab === 'branding'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <h2 class="text-lg font-black text-slate-900 mb-6 pb-4 border-b border-slate-100">Branding & Logo</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        {{-- Main Logo --}}
                        <div x-data="{ logoPreview: '{{ isset($settings['site_logo']) ? asset('storage/'.$settings['site_logo']) : '' }}' }">
                            <label class="block text-sm font-bold text-slate-700 mb-3">Main Site Logo</label>
                            
                            <div class="relative w-full aspect-video rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden hover:bg-slate-100 transition-colors cursor-pointer" @click="$refs.logoInput.click()">
                                <template x-if="logoPreview">
                                    <img :src="logoPreview" class="absolute inset-0 w-full h-full object-contain p-4 z-10" />
                                </template>
                                <div class="text-center z-0" :class="{ 'opacity-0': logoPreview }">
                                    <x-fas-plus class="w-10 h-10 text-slate-400 mx-auto mb-2" />
                                    <p class="text-xs font-semibold text-slate-500">Click to upload logo</p>
                                </div>
                            </div>
                            <input x-ref="logoInput" type="file" name="site_logo" accept="image/*" class="hidden" @change="let f = $event.target.files[0]; if(f) { let r = new FileReader(); r.onload = (e) => logoPreview = e.target.result; r.readAsDataURL(f); }">
                            <p class="text-[11px] text-slate-400 mt-3 text-center">Recommended: 400x100px (PNG or SVG with transparent background).</p>
                        </div>

                        {{-- Favicon --}}
                        <div x-data="{ faviconPreview: '{{ isset($settings['favicon']) ? asset('storage/'.$settings['favicon']) : '' }}' }">
                            <label class="block text-sm font-bold text-slate-700 mb-3">Favicon (Browser Tab Icon)</label>
                            
                            <div class="relative w-32 h-32 mx-auto rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden hover:bg-slate-100 transition-colors cursor-pointer" @click="$refs.faviconInput.click()">
                                <template x-if="faviconPreview">
                                    <img :src="faviconPreview" class="absolute inset-0 w-full h-full object-contain p-4 z-10" />
                                </template>
                                <div class="text-center z-0" :class="{ 'opacity-0': faviconPreview }">
                                    <x-fas-plus class="w-8 h-8 text-slate-400 mx-auto mb-1" />
                                    <p class="text-[10px] font-semibold text-slate-500">Upload Icon</p>
                                </div>
                            </div>
                            <input x-ref="faviconInput" type="file" name="favicon" accept="image/*" class="hidden" @change="let f = $event.target.files[0]; if(f) { let r = new FileReader(); r.onload = (e) => faviconPreview = e.target.result; r.readAsDataURL(f); }">
                            <p class="text-[11px] text-slate-400 mt-3 text-center">Recommended: 64x64px (ICO or PNG).</p>
                        </div>
                    </div>
                </div>

                {{-- Tab: Contact & Location --}}
                <div x-show="activeTab === 'contact'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <h2 class="text-lg font-black text-slate-900 mb-6 pb-4 border-b border-slate-100">Contact & Location</h2>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Support Email</label>
                                <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="hello@ogechihospital.com">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Phone Number</label>
                                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="+1 (555) 123-4567">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Physical Address</label>
                            <textarea name="contact_address" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium">{{ $settings['contact_address'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Google Maps Embed URL</label>
                            <input type="text" name="google_maps_url" value="{{ $settings['google_maps_url'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="https://www.google.com/maps/embed?...">
                        </div>
                    </div>
                </div>

                {{-- Tab: Mail Settings --}}
                <div x-show="activeTab === 'mail'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <h2 class="text-lg font-black text-slate-900 mb-6 pb-4 border-b border-slate-100">Mail Configuration (Resend)</h2>

                    <div class="bg-blue-50 text-blue-800 p-4 rounded-xl border border-blue-100 mb-6 flex items-start gap-3">
                        <x-fas-eye class="w-5 h-5 shrink-0 mt-0.5 text-blue-600" />
                        <div class="text-sm font-medium">
                            <p>This system uses <a href="https://resend.com" target="_blank" class="underline font-bold">Resend</a> for email delivery. Enter your API key from your Resend dashboard.</p>
                            <p class="mt-1 text-blue-700">Get your API key at <span class="font-mono font-bold">resend.com/api-keys</span></p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Resend API Key</label>
                            <input type="password" name="resend_api_key"
                                   value="{{ $settings['resend_api_key'] ?? '' }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium font-mono"
                                   placeholder="re_xxxxxxxxxxxxxxxxxxxxxxxx">
                            <p class="text-xs text-slate-500 mt-1.5">Keep this key secret. It grants access to send emails on your behalf.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">From Address</label>
                            <input type="email" name="mail_from_address"
                                   value="{{ $settings['mail_from_address'] ?? '' }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium"
                                   placeholder="no-reply@yourdomain.com">
                            <p class="text-xs text-slate-500 mt-1.5">Must be from a verified domain on Resend. Use <span class="font-mono">no-reply@resend.dev</span> for testing.</p>
                        </div>
                    </div>
                </div>

                {{-- Tab: SEO --}}
                <div x-show="activeTab === 'seo'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <h2 class="text-lg font-black text-slate-900 mb-6 pb-4 border-b border-slate-100">SEO & Metadata</h2>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Meta Title</label>
                            <input type="text" name="seo_title" value="{{ $settings['seo_title'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="Ogechi Hospital - Premium Healthcare">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Meta Description</label>
                            <textarea name="seo_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="Providing world-class medical services..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Meta Keywords (Comma separated)</label>
                            <input type="text" name="seo_keywords" value="{{ $settings['seo_keywords'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="hospital, healthcare, clinic">
                        </div>
                    </div>
                </div>

                {{-- Tab: Social Media --}}
                <div x-show="activeTab === 'social'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <h2 class="text-lg font-black text-slate-900 mb-6 pb-4 border-b border-slate-100">Social Media Links</h2>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Facebook URL</label>
                                <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="https://facebook.com/ogechihospital">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Twitter / X URL</label>
                                <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="https://twitter.com/ogechihospital">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Instagram URL</label>
                                <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="https://instagram.com/ogechihospital">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">LinkedIn URL</label>
                                <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium" placeholder="https://linkedin.com/company/ogechihospital">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab: System Preferences --}}
                <div x-show="activeTab === 'preferences'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <h2 class="text-lg font-black text-slate-900 mb-6 pb-4 border-b border-slate-100">System Preferences</h2>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Patient ID Prefix</label>
                                <input type="text" name="patient_id_prefix" value="{{ $settings['patient_id_prefix'] ?? 'PT-' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium">
                                <p class="text-xs text-slate-500 mt-2">Example: PT-0001</p>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Invoice Prefix</label>
                                <input type="text" name="invoice_prefix" value="{{ $settings['invoice_prefix'] ?? 'INV-' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white text-slate-900 font-medium">
                                <p class="text-xs text-slate-500 mt-2">Example: INV-2024-001</p>
                            </div>
                        </div>
                        
                        <div class="pt-4 mt-6 border-t border-slate-100">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="allow_patient_registration" value="0">
                                <input type="checkbox" name="allow_patient_registration" value="1" {{ ($settings['allow_patient_registration'] ?? '1') == '1' ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-bold text-slate-700">Allow Public Patient Registration</span>
                            </label>
                            <p class="text-xs text-slate-500 mt-1 ml-8">If checked, patients can sign up through the public portal.</p>
                        </div>
                    </div>
                </div>

                {{-- Tab: Homepage Content --}}
                <div x-show="activeTab === 'homepage'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <h2 class="text-lg font-black text-slate-900 mb-6 pb-4 border-b border-slate-100">Homepage Content</h2>
                    
                    <div class="space-y-8">
                        {{-- Hero Section --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h3 class="text-base font-bold text-slate-800 mb-4">Hero Section</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Hero Headline</label>
                                    <input type="text" name="home_hero_headline" value="{{ $settings['home_hero_headline'] ?? 'Best Caring, Better Doctors' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Hero Description</label>
                                    <textarea name="home_hero_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">{{ $settings['home_hero_description'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' }}</textarea>
                                </div>

                                {{-- Floating Cards --}}
                                <div class="pt-2 border-t border-slate-200">
                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Floating Info Cards</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="bg-white border border-blue-100 rounded-xl p-4 space-y-3">
                                            <p class="text-xs font-bold text-blue-700 flex items-center gap-1.5">
                                                <x-fas-chart-bar class="w-3.5 h-3.5" />
                                                Card 1 (left — blue)
                                            </p>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 mb-1">Title</label>
                                                <input type="text" name="hero_card1_title" value="{{ $settings['hero_card1_title'] ?? '24/7 Emergency Services' }}" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 mb-1">Description</label>
                                                <textarea name="hero_card1_desc" rows="2" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 resize-none">{{ $settings['hero_card1_desc'] ?? 'Round-the-clock emergency care available for every patient, every day.' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="bg-white border border-green-100 rounded-xl p-4 space-y-3">
                                            <p class="text-xs font-bold text-green-700 flex items-center gap-1.5">
                                                <x-fas-cog class="w-3.5 h-3.5" />
                                                Card 2 (right — green)
                                            </p>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 mb-1">Title</label>
                                                <input type="text" name="hero_card2_title" value="{{ $settings['hero_card2_title'] ?? 'Skilled Medical Professionals' }}" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 mb-1">Description</label>
                                                <textarea name="hero_card2_desc" rows="2" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-slate-50 resize-none">{{ $settings['hero_card2_desc'] ?? 'Our certified specialists bring world-class expertise to every consultation.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- About Section --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h3 class="text-base font-bold text-slate-800 mb-4">About Section</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">About Headline</label>
                                    <input type="text" name="home_about_headline" value="{{ $settings['home_about_headline'] ?? 'We Are Best Professional In Medical Sectors' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">About Description</label>
                                    <textarea name="home_about_description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">{{ $settings['home_about_description'] ?? 'Fugiat ut voluptate quo. Occaecat hic aute corporis culpitur facilius laboris excepteur, labore et Repnat emdolit. Patturiam, sint aute risus ture.' }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Services Section --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h3 class="text-base font-bold text-slate-800 mb-4">Services Section</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Services Headline</label>
                                    <input type="text" name="home_services_headline" value="{{ $settings['home_services_headline'] ?? 'Extra Ordinary Health Solutions' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                            </div>
                        </div>

                        {{-- Statistics Section --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h3 class="text-base font-bold text-slate-800 mb-4">Statistics Counters</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Happy Patients</label>
                                    <input type="number" name="home_stats_patients" value="{{ $settings['home_stats_patients'] ?? '25000' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Expert Doctors</label>
                                    <input type="number" name="home_stats_doctors" value="{{ $settings['home_stats_doctors'] ?? '410' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Years Experience</label>
                                    <input type="number" name="home_stats_experience" value="{{ $settings['home_stats_experience'] ?? '17' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Departments</label>
                                    <input type="number" name="home_stats_departments" value="{{ $settings['home_stats_departments'] ?? '33' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                            </div>
                        </div>

                        {{-- Doctors Section --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h3 class="text-base font-bold text-slate-800 mb-4">Doctors Section</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Doctors Headline</label>
                                    <input type="text" name="home_doctors_headline" value="{{ $settings['home_doctors_headline'] ?? 'Meet Our Experienced Medical Doctors' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                            </div>
                        </div>

                        {{-- Process Section --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h3 class="text-base font-bold text-slate-800 mb-4">Process Section</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Process Headline</label>
                                    <input type="text" name="home_process_headline" value="{{ $settings['home_process_headline'] ?? 'Simple Process We Follow' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Step 1 Title</label>
                                        <input type="text" name="home_process_step1" value="{{ $settings['home_process_step1'] ?? 'Book Appointment' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Step 2 Title</label>
                                        <input type="text" name="home_process_step2" value="{{ $settings['home_process_step2'] ?? 'Doctor Consultation' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Step 3 Title</label>
                                        <input type="text" name="home_process_step3" value="{{ $settings['home_process_step3'] ?? 'Treatment Plan' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Step 4 Title</label>
                                        <input type="text" name="home_process_step4" value="{{ $settings['home_process_step4'] ?? 'Fast Recovery' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CTA Section --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h3 class="text-base font-bold text-slate-800 mb-4">Call to Action (CTA) Section</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">CTA Headline</label>
                                    <input type="text" name="home_cta_headline" value="{{ $settings['home_cta_headline'] ?? 'Best Caring For You' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">CTA Description</label>
                                    <textarea name="home_cta_description" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">{{ $settings['home_cta_description'] ?? 'Our dedicated team of medical professionals is here around the clock to provide you with the best possible care.' }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Testimonials Section --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h3 class="text-base font-bold text-slate-800 mb-4">Testimonials Section</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Testimonials Headline</label>
                                    <input type="text" name="home_testimonials_headline" value="{{ $settings['home_testimonials_headline'] ?? 'Our Happy Patient\'s Genuine Reviews' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                            </div>
                        </div>

                        {{-- Blog Section --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h3 class="text-base font-bold text-slate-800 mb-4">Blog Section</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Blog Headline</label>
                                    <input type="text" name="home_blog_headline" value="{{ $settings['home_blog_headline'] ?? 'Read Our Recent Insights & Blogs' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white font-medium">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" :disabled="isSaving" class="flex items-center gap-2 px-6 py-3 text-sm font-bold text-white rounded-xl shadow-md shadow-blue-500/20 transition-all hover:opacity-90 hover:scale-[1.02] disabled:opacity-70 disabled:cursor-not-allowed" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    
                    {{-- Show save icon when NOT saving --}}
                    <x-fas-save x-show="!isSaving" class="w-5 h-5" />
                    
                    {{-- Show spinning cog when saving --}}
                    <x-fas-cog x-show="isSaving" class="animate-spin w-5 h-5" />
                    
                    <span x-text="isSaving ? 'Saving...' : 'Save Settings'"></span>
                </button>
            </div>

            </form>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         x-cloak
         class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-6 py-4 bg-slate-900 text-white rounded-2xl shadow-xl shadow-slate-900/20">
        <x-fas-plus class="w-6 h-6 text-emerald-400" />
        <span class="font-medium" x-text="toastMessage"></span>
    </div>

</div>
</x-admin-layout>

