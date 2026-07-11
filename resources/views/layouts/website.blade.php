<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $metaDescription ?? 'Ogechi Hospital — Best Caring, Better Doctors. Premium healthcare with world-class specialists and modern medical facilities.' }}">

        <title>{{ $title ?? config('app.name', 'Ogechi Hospital') }}</title>

        {{-- Google Fonts: Poppins --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            *, *::before, *::after { box-sizing: border-box; }
            html { scroll-behavior: smooth; }
            body { font-family: 'Poppins', sans-serif; }

            /* Custom scrollbar */
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: #f1f5f9; }
            ::-webkit-scrollbar-thumb { background: #0B5ED7; border-radius: 3px; }

            /* Hero background shape */
            .hero-bg-shape {
                background: linear-gradient(135deg, #062C77 0%, #0B5ED7 60%, #1e5fa8 100%);
                border-radius: 0 0 80% 0 / 0 0 30% 0;
            }

            /* Floating card animation */
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
            }
            .float-anim { animation: float 3s ease-in-out infinite; }
            .float-anim-delay { animation: float 3s ease-in-out infinite 1.5s; }

            /* Gradient text */
            .text-gradient {
                background: linear-gradient(135deg, #0B5ED7, #3B82F6);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Section reveal animation */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .fade-in-up { animation: fadeInUp 0.6s ease forwards; }

            /* Pulse ring for CTA */
            @keyframes pulse-ring {
                0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(11, 94, 215, 0.5); }
                70% { transform: scale(1); box-shadow: 0 0 0 12px rgba(11, 94, 215, 0); }
                100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(11, 94, 215, 0); }
            }
            .pulse-btn { animation: pulse-ring 2s infinite; }

            /* Sticky nav shadow on scroll */
            .nav-scrolled { box-shadow: 0 4px 30px rgba(11, 94, 215, 0.15); }

            /* Number counter animation */
            @keyframes countUp {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="bg-white antialiased overflow-x-hidden">

        {{ $slot }}

        {{-- Back to top button --}}
        <button
            id="back-to-top"
            onclick="window.scrollTo({top:0,behavior:'smooth'})"
            class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg shadow-blue-600/30 flex items-center justify-center opacity-0 translate-y-4 transition-all duration-300 hover:bg-blue-700 hover:scale-110"
            aria-label="Back to top"
        >
            <x-fas-flask class="w-5 h-5" />
        </button>

        <script>
            // Back to top visibility
            const backBtn = document.getElementById('back-to-top');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backBtn.classList.remove('opacity-0', 'translate-y-4');
                    backBtn.classList.add('opacity-100', 'translate-y-0');
                } else {
                    backBtn.classList.add('opacity-0', 'translate-y-4');
                    backBtn.classList.remove('opacity-100', 'translate-y-0');
                }
            });

            // Sticky nav
            const navbar = document.getElementById('main-navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 80) {
                    navbar?.classList.add('nav-scrolled');
                } else {
                    navbar?.classList.remove('nav-scrolled');
                }
            });

            // Intersection Observer for stats counter
            const counters = document.querySelectorAll('[data-count]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const target = parseInt(el.dataset.count);
                        const suffix = el.dataset.suffix || '';
                        let current = 0;
                        const increment = Math.ceil(target / 60);
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            el.textContent = current + suffix;
                        }, 25);
                        observer.unobserve(el);
                    }
                });
            }, { threshold: 0.5 });
            counters.forEach(c => observer.observe(c));
        </script>
    </body>
</html>
