<x-layouts.website title="Blog – Ogechi Hospital" metaDescription="Read the latest health tips, medical news, and expert insights from Ogechi Hospital's team of specialist doctors.">

    <x-website.header-bar />
    <x-website.navbar />

    <x-website.page-hero
        title="Health Insights &amp; Blog"
        subtitle="Expert medical advice, health tips, and the latest news from Ogechi Hospital's team of specialist physicians."
        :breadcrumbs="[['label'=>'Home','route'=>'home'],['label'=>'Blog']]"
        icon="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
    />

    <section class="py-20 lg:py-28 bg-[#F5F9FF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($posts->isEmpty())
                {{-- Empty state --}}
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-blue-100">
                        <x-fas-eye class="w-10 h-10 text-blue-300" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Articles Published Yet</h3>
                    <p class="text-gray-500 text-sm max-w-sm mx-auto">Our team is working on health articles. Please check back soon for expert insights and tips.</p>
                </div>
            @else
                {{-- Category filter (dynamic from actual posts) --}}
                @php
                    $categories = $posts->pluck('category')->unique()->filter()->values();
                @endphp
                <div x-data="{ cat: 'all' }" class="flex flex-wrap gap-2 justify-center mb-12">
                    <button
                        @click="cat = 'all'"
                        :class="cat === 'all' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-300 hover:text-blue-600'"
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200"
                    >All Posts</button>
                    @foreach($categories as $cat)
                        <button
                            @click="cat = '{{ $cat }}'"
                            :class="cat === '{{ $cat }}' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-300 hover:text-blue-600'"
                            class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200"
                        >{{ $cat }}</button>
                    @endforeach
                </div>

                {{-- Blog Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                        @php
                            $grad     = $post->grad     ?: 'from-blue-400 to-blue-600';
                            $iconPath = $post->icon_path ?: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z';
                            $catColor = $post->cat_color ?: 'bg-blue-100 text-blue-600';
                            $readTime = $post->read_time ?: '5 min read';
                        @endphp
                        <article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-blue-900/10 border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2 flex flex-col">
                            {{-- Thumbnail --}}
                            <a href="{{ route('website.blog.show', $post->slug) }}" class="h-52 bg-gradient-to-br {{ $grad }} relative overflow-hidden flex-shrink-0 block">
                                @if($post->thumbnail)
                                    <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20">
                                            <x-fas-eye class="w-10 h-10 text-white" />
                                        </div>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="{{ $catColor }} text-xs font-bold px-3 py-1 rounded-full bg-white shadow-sm">{{ $post->category }}</span>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-full border border-white/30">{{ $readTime }}</span>
                                </div>
                                <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors duration-300 flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100">
                                    <span class="bg-white text-blue-700 text-xs font-bold px-4 py-1.5 rounded-full shadow-lg">Read Article →</span>
                                </div>
                            </a>

                            <div class="p-5 flex flex-col gap-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5 text-gray-400">
                                        <x-fas-tachometer-alt class="w-3.5 h-3.5" />
                                        <time datetime="{{ $post->published_at?->format('Y-m-d') }}" class="text-xs font-medium">{{ $post->published_at?->format('M d, Y') ?? '—' }}</time>
                                    </div>
                                    <span class="text-xs text-blue-600 font-semibold">By {{ $post->author }}</span>
                                </div>
                                <h2 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-blue-700 transition-colors line-clamp-2">
                                    <a href="{{ route('website.blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 flex-1">{{ $post->excerpt }}</p>
                                <a href="{{ route('website.blog.show', $post->slug) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors mt-auto pt-3 border-t border-gray-100 group/link">
                                    Read More
                                    <x-fas-eye class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" />
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    <x-website.cta />
    <x-website.footer />
</x-layouts.website>
