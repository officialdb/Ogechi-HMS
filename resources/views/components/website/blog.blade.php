{{-- BLOG SECTION --}}
<section id="blog" class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-14">
            <div>
                <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    Latest News
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">
                    Read Our Recent<br>
                    <span class="text-gradient">Insights & Blogs</span>
                </h2>
            </div>
            <a href="#" class="inline-flex items-center gap-2 border-2 border-blue-600 text-blue-600 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300 w-fit">
                View All Posts
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        {{-- Blog Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $posts = [
                    [
                        'category'  => 'Cardiology',
                        'cat_color' => 'bg-red-100 text-red-600',
                        'date'      => 'May 18, 2026',
                        'title'     => 'Understanding Heart Health: Tips for a Stronger Cardiovascular System',
                        'excerpt'   => 'Maintaining a healthy heart requires consistent lifestyle habits. Learn how simple daily choices — from diet to exercise — can dramatically improve cardiovascular outcomes.',
                        'read_time' => '5 min read',
                        'grad'      => 'from-red-400 to-rose-600',
                        'icon_path' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                    ],
                    [
                        'category'  => 'Neurology',
                        'cat_color' => 'bg-violet-100 text-violet-600',
                        'date'      => 'May 12, 2026',
                        'title'     => 'Brain Health in the Digital Age: Managing Screen Time and Mental Fatigue',
                        'excerpt'   => 'As screen usage increases globally, neurologists are seeing a rise in digital fatigue. Discover expert-backed strategies to protect your brain health and maintain sharp cognition.',
                        'read_time' => '7 min read',
                        'grad'      => 'from-violet-400 to-purple-600',
                        'icon_path' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                    ],
                    [
                        'category'  => 'General Health',
                        'cat_color' => 'bg-blue-100 text-blue-600',
                        'date'      => 'May 5, 2026',
                        'title'     => 'Why Regular Health Screenings Are Essential for Preventive Care',
                        'excerpt'   => 'Early detection saves lives. We break down which health screenings are recommended at every age and why a proactive approach to healthcare is always the smartest investment.',
                        'read_time' => '6 min read',
                        'grad'      => 'from-blue-400 to-blue-600',
                        'icon_path' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    ],
                ];
            @endphp

            @foreach($posts as $post)
                <article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-blue-900/10 border border-gray-100 hover:border-blue-100 transition-all duration-300 hover:-translate-y-2 flex flex-col">

                    {{-- Thumbnail --}}
                    <div class="h-48 bg-gradient-to-br {{ $post['grad'] }} relative overflow-hidden flex-shrink-0">
                        <div class="absolute inset-0 flex items-center justify-center opacity-20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $post['icon_path'] }}"/>
                            </svg>
                        </div>
                        {{-- Medical cross watermark --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $post['icon_path'] }}"/>
                                </svg>
                            </div>
                        </div>
                        {{-- Category Badge --}}
                        <div class="absolute top-4 left-4">
                            <span class="{{ $post['cat_color'] }} text-xs font-bold px-3 py-1 rounded-full bg-white shadow-sm">{{ $post['category'] }}</span>
                        </div>
                        {{-- Read time badge --}}
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-full border border-white/30">{{ $post['read_time'] }}</span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col gap-3 flex-1">
                        {{-- Date --}}
                        <div class="flex items-center gap-1.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs font-medium">{{ $post['date'] }}</span>
                        </div>

                        <h3 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-blue-700 transition-colors line-clamp-2">
                            {{ $post['title'] }}
                        </h3>

                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 flex-1">
                            {{ $post['excerpt'] }}
                        </p>

                        <a href="#" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors mt-auto pt-2 border-t border-gray-100 group/link">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
