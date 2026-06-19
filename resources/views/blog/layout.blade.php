<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Le Rouleau Gris') — Fragments d'une vie pensante</title>
    <meta name="description" content="@yield('description', 'Un carnet numérique mêlant poésie, philosophie, technologie et réflexions personnelles.')">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        garamond: ['"EB Garamond"', 'serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        surface: '#0e0e0b',
                        parchment: '#e5e2db',
                        silver: '#a0a09a',
                        charcoal: '#1a1a17',
                        ink: '#131410',
                    }
                }
            }
        }
    </script>
    <script>
        if (!('theme' in localStorage)) localStorage.theme = 'dark';
        if (localStorage.theme === 'dark') document.documentElement.classList.add('dark');
        else document.documentElement.classList.remove('dark');

        window.toggleDarkMode = function() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
            const btn = document.getElementById('dark-mode-btn');
            if (btn) btn.textContent = html.classList.contains('dark') ? '○' : '●';
        }
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('dark-mode-btn');
            if (btn) btn.textContent = document.documentElement.classList.contains('dark') ? '○' : '●';
        });
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .garamond, .font-garamond { font-family: 'EB Garamond', serif; }
        body { background: #0e0e0b; color: #e5e2db; }
        body.light { background: #f5f2eb; color: #1a1a17; }

        /* Barre de progression */
        #progress-bar {
            position: fixed; top: 0; left: 0; height: 1px;
            background: linear-gradient(90deg, #a0a09a, #e5e2db);
            z-index: 100; transition: width 0.1s linear;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #0e0e0b; }
        ::-webkit-scrollbar-thumb { background: #2a2a26; }
        ::-webkit-scrollbar-thumb:hover { background: #3a3935; }

        /* Prose */
        .prose-rouleau {
            font-family: 'EB Garamond', serif;
            font-size: 1.15rem;
            line-height: 1.9;
            color: #c4c1ba;
        }
        .prose-rouleau p { margin-bottom: 1.5em; }
        .prose-rouleau h2 {
            font-family: 'EB Garamond', serif;
            font-size: 1.5em;
            color: #e5e2db;
            margin: 2em 0 0.8em;
            font-style: italic;
        }

        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.8s ease forwards; }
        .fade-up-delay-1 { animation-delay: 0.1s; opacity: 0; }
        .fade-up-delay-2 { animation-delay: 0.2s; opacity: 0; }
        .fade-up-delay-3 { animation-delay: 0.3s; opacity: 0; }

        /* Card hover */
        .card-hover {
            transition: all 0.5s ease;
            border: 1px solid #1c1c18;
        }
        .card-hover:hover {
            border-color: #3a3935;
            background: #131410;
            transform: translateY(-2px);
        }

        /* Light mode */
        .light body, body.light-mode {
            background: #f5f2eb !important;
            color: #1a1a17 !important;
        }
    </style>
</head>
<body class="min-h-screen transition-colors duration-500" style="background:#0e0e0b; color:#e5e2db;">

{{-- Barre de progression --}}
<div id="progress-bar" style="width:0%"></div>

{{-- Bouton retour en haut --}}
<button id="back-to-top" onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="fixed bottom-8 right-8 w-8 h-8 border border-white/10 text-white/30
               flex items-center justify-center opacity-0 transition-all duration-500 z-50
               hover:border-white/30 hover:text-white/60 text-sm">
    ↑
</button>

{{-- NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 z-40 border-b border-white/5"
     style="background: rgba(14,14,11,0.92); backdrop-filter: blur(12px);">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ route('blog.index') }}" class="flex flex-col leading-none group">
            <span class="font-garamond italic text-xl text-parchment/90 group-hover:text-white transition duration-300">
                Le Rouleau Gris
            </span>
        </a>

        {{-- Navigation centrale --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('blog.index') }}"
               class="font-inter text-xs tracking-[0.2em] uppercase text-silver/50 hover:text-parchment/80 transition duration-300">
                Fragments
            </a>
            @foreach(\App\Models\Category::limit(3)->get() as $cat)
            <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
               class="font-inter text-xs tracking-[0.2em] uppercase text-silver/50 hover:text-parchment/80 transition duration-300">
                {{ $cat->name }}
            </a>
            @endforeach
            <a href="{{ route('blog.about') }}"
               class="font-inter text-xs tracking-[0.2em] uppercase text-silver/50 hover:text-parchment/80 transition duration-300">
                Archive
            </a>
        </div>

        {{-- Menu droit --}}
        <div class="flex items-center gap-5">

            {{-- Recherche --}}
            <form method="GET" action="{{ route('blog.index') }}" class="hidden md:flex items-center">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Chercher..."
                       class="bg-transparent border-b border-white/10 text-xs text-parchment/60
                              placeholder-white/20 px-0 py-1 w-32 focus:outline-none focus:border-white/30
                              focus:w-48 transition-all duration-500 font-inter">
            </form>

            {{-- Dark mode --}}
            <button onclick="toggleDarkMode()" id="dark-mode-btn"
                    class="text-silver/40 hover:text-parchment/70 transition text-sm font-inter">○</button>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="font-inter text-[10px] tracking-[0.2em] uppercase border border-white/15
                              text-silver/60 px-3 py-1.5 hover:border-white/30 hover:text-parchment/80 transition duration-300">
                        Admin
                    </a>
                @else
                    <span class="font-inter text-xs text-silver/40 hidden md:block">
                        {{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="font-inter text-[10px] tracking-[0.2em] uppercase text-silver/30
                                       hover:text-parchment/60 transition">
                            Partir
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="font-inter text-[10px] tracking-[0.2em] uppercase text-silver/40
                          hover:text-parchment/70 transition">
                    Entrer
                </a>
                <a href="{{ route('register') }}"
                   class="font-inter text-[10px] tracking-[0.2em] uppercase border border-white/15
                          text-silver/60 px-3 py-1.5 hover:border-white/30 hover:text-parchment/80 transition duration-300">
                    Rejoindre
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- CONTENU --}}
<main class="pt-16">
    @if(session('success'))
    <div class="max-w-6xl mx-auto px-6 mt-4">
        <div class="border-l-2 border-silver/30 pl-3 py-2 text-xs text-silver/60 font-inter">
            {{ session('success') }}
        </div>
    </div>
    @endif
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="mt-24 border-t border-white/5">
    <div class="max-w-6xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">

            <div>
                <div class="font-garamond italic text-2xl text-parchment/80 mb-3">Le Rouleau Gris</div>
                <p class="font-inter text-xs text-silver/40 leading-relaxed max-w-xs">
                    Un carnet numérique. Des fragments de poésie, de philosophie,
                    de technologie et de mémoire.
                </p>
            </div>

            <div>
                <p class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-4">Catégories</p>
                @foreach(\App\Models\Category::all() as $cat)
                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                   class="block font-garamond italic text-silver/50 hover:text-parchment/80 transition mb-1.5 text-sm">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>

            <div>
                <p class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-4">Navigation</p>
                <a href="{{ route('blog.index') }}"
                   class="block font-inter text-xs text-silver/40 hover:text-parchment/70 transition mb-2 tracking-wide">
                    Tous les fragments
                </a>
                <a href="{{ route('blog.about') }}"
                   class="block font-inter text-xs text-silver/40 hover:text-parchment/70 transition mb-2 tracking-wide">
                    À propos de l'archive
                </a>
                @guest
                <a href="{{ route('register') }}"
                   class="block font-inter text-xs text-silver/40 hover:text-parchment/70 transition mb-2 tracking-wide">
                    Rejoindre
                </a>
                @endguest
            </div>
        </div>

        <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-3">
            <span class="font-inter text-[10px] text-silver/20 tracking-widest uppercase">
                © {{ date('Y') }} Le Rouleau Gris
            </span>
            <span class="font-garamond italic text-silver/20 text-sm">
                Archive d'une vie pensante
            </span>
        </div>
    </div>
</footer>

<script>
    // Barre de progression
    const progressBar = document.getElementById('progress-bar');
    const backToTop = document.getElementById('back-to-top');
    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        if (progressBar) progressBar.style.width = (docHeight > 0 ? scrollTop / docHeight * 100 : 0) + '%';
        if (backToTop) backToTop.style.opacity = scrollTop > 300 ? '1' : '0';
    });

    // Intersection Observer pour animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.card-hover').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(12px)';
        el.style.transition = 'opacity 0.7s ease, transform 0.7s ease, border-color 0.5s ease, background 0.5s ease';
        observer.observe(el);
    });
</script>

</body>
</html>