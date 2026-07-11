<x-layouts.website title="Page Not Found – Ogechi Hospital" metaDescription="The page you are looking for does not exist. Return to Ogechi Hospital homepage.">

    <x-website.header-bar />
    <x-website.navbar />

    <section class="py-24 bg-[#F5F9FF] min-h-[60vh] flex flex-col justify-center">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-lg shadow-blue-900/10 mb-8 border-4 border-blue-50">
                <x-fas-eye class="w-12 h-12 text-blue-600" />
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
                    <x-fas-cog class="w-4 h-4 shrink-0" />
                    Back to Homepage
                </a>
                
                <a href="{{ route('website.contact') }}" class="min-w-[200px] whitespace-nowrap px-12 py-4 bg-white hover:bg-gray-50 text-blue-600 text-sm font-bold border border-blue-200 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/5 inline-flex items-center justify-center gap-2">
                    <x-fas-eye class="w-4 h-4 shrink-0" />
                    Contact Support
                </a>
            </div>
            
        </div>
    </section>

    <x-website.footer />
</x-layouts.website>
