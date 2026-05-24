{{--
    Page Hero / Breadcrumb Banner
    Props:
        $title       (string) – Large heading
        $subtitle    (string) – Optional sub-text
        $breadcrumbs (array)  – [['label'=>'Home','route'=>'home'], ['label'=>'Current']]
        $icon        (string) – SVG path d= attribute
--}}
<section class="relative py-16 lg:py-24 overflow-hidden" style="background: linear-gradient(135deg, #062C77 0%, #0B5ED7 60%, #1565C8 100%);">

    {{-- Decorative blobs --}}
    <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full blur-3xl -translate-y-1/3 translate-x-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/5 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    {{-- Dot pattern overlay --}}
    <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center gap-5">

            {{-- Icon --}}
            @if(!empty($icon))
                <div class="w-16 h-16 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                    </svg>
                </div>
            @endif

            {{-- Title --}}
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                {{ $title }}
            </h1>

            {{-- Subtitle --}}
            @if(!empty($subtitle))
                <p class="text-blue-200 text-base lg:text-lg max-w-xl leading-relaxed">{{ $subtitle }}</p>
            @endif

            {{-- Breadcrumb --}}
            @if(!empty($breadcrumbs))
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-sm">
                    @foreach($breadcrumbs as $i => $crumb)
                        @if($i > 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        @endif
                        @if(isset($crumb['route']))
                            <a href="{{ route($crumb['route']) }}" class="text-blue-200 hover:text-white transition-colors font-medium">{{ $crumb['label'] }}</a>
                        @else
                            <span class="text-white font-semibold">{{ $crumb['label'] }}</span>
                        @endif
                    @endforeach
                </nav>
            @endif
        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0 overflow-hidden leading-none">
        <svg viewBox="0 0 1440 40" class="w-full" fill="white" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,40 C360,0 1080,0 1440,40 L1440,40 L0,40 Z"/>
        </svg>
    </div>
</section>
