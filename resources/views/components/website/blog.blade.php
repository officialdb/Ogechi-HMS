{{-- BLOG SECTION --}}
<section id="blog" class="py-20 lg:py-28 bg-[#F5F9FF]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-14" data-aos="fade-up">
            @php
                $blogHeadline = \Modules\Settings\Models\Setting::where('key', 'home_blog_headline')->value('value') ?: 'Read Our Recent Insights & Blogs';
                $words = explode(' ', $blogHeadline);
                if (count($words) > 2) {
                    $lastTwo = array_slice($words, -2);
                    $rest = array_slice($words, 0, count($words) - 2);
                    $formattedHeadline = implode(' ', $rest) . '<br> <span class="text-gradient">' . implode(' ', $lastTwo) . '</span>';
                } else {
                    $formattedHeadline = $blogHeadline;
                }
            @endphp
            <div>
                <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-4">
                    <x-fas-newspaper class="w-3.5 h-3.5" />
                    Latest News
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">
                    {!! $formattedHeadline !!}
                </h2>
            </div>
            <a href="{{ route('website.blog') }}" class="inline-flex items-center gap-2 border-2 border-blue-600 text-blue-600 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300 w-fit">
                View All Posts
                <x-fas-arrow-right class="w-4 h-4" />
            </a>
        </div>

        {{-- Blog Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $posts = \Modules\CMS\Models\Post::where('approval_status', 'approved')->latest('published_at')->take(3)->get();
            @endphp

            @foreach($posts as $post)
                @php
                    $grad     = $post->grad     ?: 'from-blue-400 to-blue-600';
                    $iconPath = $post->icon_path ?: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z';
                    $catColor = $post->cat_color ?: 'bg-blue-100 text-blue-600';
                    $readTime = $post->read_time ?: '5 min read';
                @endphp
                <article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-blue-900/10 border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2 flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">

                    {{-- Thumbnail --}}
                    <div class="h-48 bg-gradient-to-br {{ $grad }} relative overflow-hidden flex-shrink-0">
                        @if($post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center opacity-20">
                                <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/></svg>
                            </div>
                            {{-- Medical cross watermark --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/></svg>
                                </div>
                            </div>
                        @endif
                        {{-- Category Badge --}}
                        <div class="absolute top-4 left-4">
                            <span class="{{ $catColor }} text-xs font-bold px-3 py-1 rounded-full bg-white shadow-sm">{{ $post->category }}</span>
                        </div>
                        {{-- Read time badge --}}
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-full border border-white/30">{{ $readTime }}</span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col gap-3 flex-1">
                        {{-- Date --}}
                        <div class="flex items-center gap-1.5 text-gray-400">
                            <x-fas-calendar-alt class="w-3.5 h-3.5" />
                            <span class="text-xs font-medium">{{ $post->published_at?->format('M d, Y') ?? '—' }}</span>
                        </div>

                        <h3 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-blue-700 transition-colors line-clamp-2">
                            <a href="{{ route('website.blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>

                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 flex-1">
                            {{ $post->excerpt }}
                        </p>

                        <a href="{{ route('website.blog.show', $post->slug) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors mt-auto pt-2 border-t border-gray-100 group/link">
                            Read More
                            <x-fas-arrow-right class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" />
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
