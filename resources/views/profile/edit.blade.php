<x-admin-layout title="Admin Profile">
    <div class="max-w-6xl mx-auto space-y-6">
        
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Admin Profile</h1>
                <p class="text-sm text-slate-500 mt-1">Manage your account settings, security, and preferences.</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
