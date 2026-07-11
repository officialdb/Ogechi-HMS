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
                            <x-fas-chevron-right class="w-3 h-3 text-blue-300" />
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
    <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-none">
        <svg class="block w-full h-[30px] lg:h-[50px] text-white" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118,130.4,120,192.6,104.9,235.6,94.39,280.4,76.54,321.39,56.44Z" fill="currentColor"></path>
        </svg>
    </div>
</section>
