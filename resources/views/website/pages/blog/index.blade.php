<x-layouts.website title="Blog – Ogechi Hospital" metaDescription="Read the latest health tips, medical news, and expert insights from Ogechi Hospital's team of specialist doctors.">

    <x-website.header-bar />
    <x-website.navbar />

    <x-website.page-hero
        title="Health Insights & Blog"
        subtitle="Expert medical advice, health tips, and the latest news from Ogechi Hospital's team of specialist physicians."
        :breadcrumbs="[['label'=>'Home','route'=>'home'],['label'=>'Blog']]"
        icon="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
    />

    <section class="py-20 lg:py-28 bg-[#F5F9FF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Category filter --}}
            <div x-data="{ cat: 'all' }" class="flex flex-wrap gap-2 justify-center mb-12">
                @foreach(['all'=>'All Posts','Cardiology'=>'Cardiology','Neurology'=>'Neurology','Orthopedics'=>'Orthopedics','Dentistry'=>'Dentistry','General Health'=>'General Health'] as $key => $label)
                    <button
                        @click="cat = '{{ $key }}'"
                        :class="cat === '{{ $key }}' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-300 hover:text-blue-600'"
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200"
                    >{{ $label }}</button>
                @endforeach
            </div>

            {{-- Blog Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-blue-900/10 border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2 flex flex-col">
                        {{-- Thumbnail --}}
                        <a href="{{ route('website.blog.show', $post['slug']) }}" class="h-52 bg-gradient-to-br {{ $post['grad'] }} relative overflow-hidden flex-shrink-0 block">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $post['icon_path'] }}"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span class="{{ $post['cat_color'] }} text-xs font-bold px-3 py-1 rounded-full bg-white shadow-sm">{{ $post['category'] }}</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-full border border-white/30">{{ $post['read_time'] }}</span>
                            </div>
                            {{-- Hover overlay --}}
                            <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors duration-300 flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100">
                                <span class="bg-white text-blue-700 text-xs font-bold px-4 py-1.5 rounded-full shadow-lg">Read Article →</span>
                            </div>
                        </a>

                        <div class="p-5 flex flex-col gap-3 flex-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1.5 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <time datetime="{{ $post['date_iso'] }}" class="text-xs font-medium">{{ $post['date'] }}</time>
                                </div>
                                <span class="text-xs text-blue-600 font-semibold">By {{ $post['author'] }}</span>
                            </div>
                            <h2 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-blue-700 transition-colors line-clamp-2">
                                <a href="{{ route('website.blog.show', $post['slug']) }}">{{ $post['title'] }}</a>
                            </h2>
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 flex-1">{{ $post['excerpt'] }}</p>
                            <a href="{{ route('website.blog.show', $post['slug']) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors mt-auto pt-3 border-t border-gray-100 group/link">
                                Read More
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Simple pagination placeholder --}}
            <div class="flex justify-center mt-12 gap-2">
                <button class="w-10 h-10 rounded-xl bg-blue-600 text-white font-bold text-sm shadow-md shadow-blue-600/30">1</button>
                <button class="w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 font-semibold text-sm hover:bg-blue-50 hover:border-blue-300 transition-colors">2</button>
                <button class="w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 font-semibold text-sm hover:bg-blue-50 hover:border-blue-300 transition-colors">3</button>
            </div>
        </div>
    </section>

    <x-website.cta />
    <x-website.footer />
</x-layouts.website>
