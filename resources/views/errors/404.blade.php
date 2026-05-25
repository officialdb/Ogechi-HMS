<x-layouts.website title="Page Not Found – Ogechi Hospital" metaDescription="The page you are looking for does not exist. Return to Ogechi Hospital homepage.">

    <x-website.header-bar />
    <x-website.navbar />

    <section class="py-24 bg-[#F5F9FF] min-h-[60vh] flex flex-col justify-center">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-lg shadow-blue-900/10 mb-8 border-4 border-blue-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <h1 class="text-6xl md:text-8xl font-black text-gray-900 tracking-tight mb-4 text-gradient">
                404
            </h1>
            
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                Oops! Page Not Found
            </h2>
            
            <p class="text-gray-500 text-lg max-w-xl mx-auto mb-10 leading-relaxed">
                The page you are looking for might have been removed, had its name changed, or is temporarily unavailable. Let's get you back on track.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                <a href="{{ route('home') }}" class="min-w-[200px] whitespace-nowrap px-12 py-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-600/30 inline-flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Back to Homepage
                </a>
                
                <a href="{{ route('website.contact') }}" class="min-w-[200px] whitespace-nowrap px-12 py-4 bg-white hover:bg-gray-50 text-blue-600 text-sm font-bold border border-blue-200 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/5 inline-flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Contact Support
                </a>
            </div>
            
        </div>
    </section>

    <x-website.footer />
</x-layouts.website>
