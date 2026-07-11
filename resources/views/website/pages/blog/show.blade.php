<x-layouts.website :title="$post->title.' – Ogechi Hospital'" :metaDescription="$post->excerpt">

    <x-website.header-bar />
    <x-website.navbar />

    {{-- Post Hero --}}
    <section class="relative py-20 lg:py-28 overflow-hidden" style="background: linear-gradient(135deg, #062C77 0%, #0B5ED7 60%, #1565C8 100%);">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full blur-3xl -translate-y-1/3 translate-x-1/3"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            {{-- Breadcrumb --}}
            <nav aria-label="Breadcrumb" class="flex items-center justify-center gap-2 text-sm mb-6">
                <a href="{{ route('home') }}" class="text-blue-200 hover:text-white transition-colors font-medium">Home</a>
                <x-fas-tachometer-alt class="w-3.5 h-3.5 text-blue-300" />
                <a href="{{ route('website.blog') }}" class="text-blue-200 hover:text-white transition-colors font-medium">Blog</a>
                <x-fas-tachometer-alt class="w-3.5 h-3.5 text-blue-300" />
                <span class="text-white font-semibold">Article</span>
            </nav>

            {{-- Category + Read time --}}
            <div class="flex items-center justify-center gap-3 mb-5">
                <span class="{{ $post->cat_color ?? 'bg-blue-100 text-blue-600' }} text-xs font-bold px-3 py-1 rounded-full bg-white shadow-sm">{{ $post->category }}</span>
                <span class="text-blue-200 text-xs font-medium flex items-center gap-1">
                    <x-fas-chart-bar class="w-3.5 h-3.5" />
                    {{ $post->read_time ?? '5 min read' }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
                {{ $post->title }}
            </h1>

            {{-- Author + Date --}}
            <div class="flex items-center justify-center gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr($post->author ?? 'A', 0, 1)) }}
                    </div>
                    <div class="text-left">
                        <p class="text-white font-semibold text-xs leading-none">{{ $post->author }}</p>
                        <p class="text-blue-200 text-xs mt-0.5">{{ $post->author_role ?? '' }}</p>
                    </div>
                </div>
                <div class="w-px h-8 bg-white/20"></div>
                <time datetime="{{ $post->published_at?->format('Y-m-d') }}" class="text-blue-200 text-xs flex items-center gap-1">
                    <x-fas-tachometer-alt class="w-3.5 h-3.5" />
                    {{ $post->published_at?->format('M d, Y') ?? '—' }}
                </time>
            </div>
        </div>

        {{-- Bottom wave --}}
        <div class="absolute bottom-0 left-0 right-0 overflow-hidden leading-none">
            <x-fas-home class="w-full" />
        </div>
    </section>

    {{-- Article Content + Sidebar --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Main Article --}}
                <article class="lg:col-span-2">
                    @php
                        $grad     = $post->grad     ?: 'from-blue-400 to-blue-600';
                        $iconPath = $post->icon_path ?: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z';
                    @endphp

                    {{-- Featured banner --}}
                    <div class="h-64 rounded-2xl bg-gradient-to-br {{ $grad }} mb-8 relative overflow-hidden flex items-center justify-center">
                        @if($post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="w-24 h-24 bg-white/15 backdrop-blur-sm rounded-3xl flex items-center justify-center border border-white/25">
                                <x-fas-eye class="w-12 h-12 text-white" />
                            </div>
                        @endif
                        <div class="absolute bottom-4 left-4 flex gap-2">
                            <span class="{{ $post->cat_color ?? 'bg-blue-100 text-blue-600' }} text-xs font-bold px-3 py-1 rounded-full bg-white shadow">{{ $post->category }}</span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed"
                         style="font-size: 0.9375rem; line-height: 1.75;">
                        <style>
                            .article-body h2 { font-size: 1.25rem; font-weight: 700; color: #0F172A; margin: 1.75rem 0 0.75rem; padding-bottom: 0.5rem; border-bottom: 2px solid #EFF6FF; }
                            .article-body p  { color: #4B5563; margin-bottom: 1rem; }
                        </style>
                        <div class="article-body">
                            {!! $post->body !!}
                        </div>
                    </div>

                    {{-- Share --}}
                    <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-gray-900 mb-2">Share this article</p>
                            <div class="flex gap-2">
                                @foreach([
                                    ['label'=>'Facebook','bg'=>'bg-blue-600 hover:bg-blue-700','icon'=>'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
                                    ['label'=>'Twitter', 'bg'=>'bg-sky-500 hover:bg-sky-600',  'icon'=>'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
                                    ['label'=>'LinkedIn','bg'=>'bg-blue-800 hover:bg-blue-900','icon'=>'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 4m-2 0a2 2 0 104 0 2 2 0 10-4 0'],
                                ] as $s)
                                    <a href="#" aria-label="{{ $s['label'] }}" class="{{ $s['bg'] }} text-white w-9 h-9 rounded-xl flex items-center justify-center transition-colors shadow-sm">
                                        <x-fas-tachometer-alt class="w-4 h-4" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ route('website.blog') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            <x-fas-tachometer-alt class="w-4 h-4" />
                            Back to Blog
                        </a>
                    </div>
                </article>

                {{-- Sidebar --}}
                <aside class="space-y-6">
                    {{-- Author card --}}
                    <div class="bg-[#F5F9FF] rounded-2xl p-5 border border-blue-50">
                        <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <x-fas-tachometer-alt class="w-4 h-4 text-blue-600" />
                            About the Author
                        </h3>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-base shadow-md shadow-blue-600/30">
                                {{ strtoupper(substr($post->author ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $post->author }}</p>
                                <p class="text-blue-600 text-xs font-semibold">{{ $post->author_role ?? '' }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Board-certified specialist at Ogechi Hospital with extensive clinical experience and a passion for patient education and preventive medicine.</p>
                        <a href="{{ route('website.doctors') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            View Doctors <x-fas-eye class="w-3.5 h-3.5" />
                        </a>
                    </div>

                    {{-- Book appointment mini CTA --}}
                    <div class="rounded-2xl p-5 text-white" style="background: linear-gradient(135deg, #062C77, #0B5ED7);">
                        <x-fas-tachometer-alt class="w-8 h-8 text-blue-200 mb-3" />
                        <h3 class="font-bold text-base mb-2">Need a Consultation?</h3>
                        <p class="text-blue-100 text-xs leading-relaxed mb-4">Speak directly with a specialist. Same-day appointments available.</p>
                        <a href="{{ route('website.contact') }}" class="block w-full text-center bg-white text-blue-700 font-bold text-xs py-2.5 rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                            Book Appointment
                        </a>
                    </div>

                    {{-- Related Posts --}}
                    @if($related->isNotEmpty())
                        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                            <h3 class="text-sm font-bold text-gray-900 mb-4">Related Articles</h3>
                            <div class="space-y-4">
                                @foreach($related as $rel)
                                    @php
                                        $relGrad     = $rel->grad     ?: 'from-blue-400 to-blue-600';
                                        $relIconPath = $rel->icon_path ?: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z';
                                    @endphp
                                    <a href="{{ route('website.blog.show', $rel->slug) }}" class="flex gap-3 group">
                                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br {{ $relGrad }} flex-shrink-0 flex items-center justify-center">
                                            <x-fas-home class="w-7 h-7 text-white" />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-gray-900 group-hover:text-blue-700 transition-colors line-clamp-2 leading-snug">{{ $rel->title }}</p>
                                            <p class="text-xs text-blue-600 font-medium mt-1">{{ $rel->published_at?->format('M d, Y') ?? '—' }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Departments quick links (live from DB) --}}
                    @php
                        $sideDepts = \Modules\Departments\Models\Department::where('status','active')->take(6)->pluck('name');
                    @endphp
                    @if($sideDepts->isNotEmpty())
                        <div class="bg-[#F5F9FF] rounded-2xl p-5 border border-blue-50">
                            <h3 class="text-sm font-bold text-gray-900 mb-3">Our Departments</h3>
                            <div class="space-y-2">
                                @foreach($sideDepts as $deptName)
                                    <a href="{{ route('website.services') }}" class="flex items-center justify-between text-xs font-medium text-gray-600 hover:text-blue-600 py-1.5 border-b border-gray-100 last:border-0 transition-colors group">
                                        {{ $deptName }}
                                        <x-fas-tachometer-alt class="w-3.5 h-3.5 text-gray-400 group-hover:text-blue-600 transition-colors" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    <x-website.cta />
    <x-website.footer />
</x-layouts.website>
