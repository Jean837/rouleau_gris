<!DOCTYPE html>
<html lang="fr" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Le Rouleau Gris') — Fragments d'une vie pensante</title>
    <meta name="description" content="@yield('description', 'Un carnet numérique mêlant poésie, philosophie, technologie et réflexions personnelles.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Playfair Display', 'Georgia', 'serif'],
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        charcoal: '#1a1a1a',
                        parchment: '#f5f0e8',
                    }
                }
            }
        }
    </script>
    <script>
        // Thème par défaut : sombre
        if (!('theme' in localStorage)) localStorage.theme = 'dark';
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

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
            if (btn) btn.textContent = html.classList.contains('dark') ? '☀️' : '🌙';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('dark-mode-btn');
            if (btn) btn.textContent = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
        });
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', Georgia, serif; }
        .prose-rouleau p { margin-bottom: 1.5em; line-height: 1.9; }
        .prose-rouleau h2 { font-family: 'Playfair Display', serif; font-size: 1.4em; margin: 2em 0 0.8em; }
        /* Barre de progression */
        #progress-bar { position: fixed; top: 0; left: 0; height: 2px; background: linear-gradient(90deg, #8B5CF6, #6B7280); z-index: 100; transition: width 0.1s; }
    </style>
</head>
<body class="bg-stone-950 text-stone-200 dark:bg-stone-950 dark:text-stone-200 min-h-screen transition-colors duration-500">

{{-- Barre de progression --}}
<div id="progress-bar" style="width:0%"></div>

{{-- Bouton retour en haut --}}
<button id="back-to-top" onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="fixed bottom-8 right-8 w-10 h-10 bg-stone-800 border border-stone-700 text-stone-400
               rounded-full flex items-center justify-center opacity-0 transition-all duration-300 z-50
               hover:text-white hover:border-stone-500">
    ↑
</button>

{{-- NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 z-40 bg-stone-950/90 backdrop-blur-md border-b border-stone-800">
    <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ route('blog.index') }}" class="flex flex-col leading-none group">
            <span class="font-serif text-xl text-stone-100 group-hover:text-stone-300 transition">Le Rouleau</span>
            <span class="font-serif text-xl text-stone-400 italic group-hover:text-stone-300 transition">Gris</span>
        </a>

        {{-- Nav liens --}}
        <div class="hidden md:flex items-center gap-8 text-sm text-stone-400">
            <a href="{{ route('blog.index') }}" class="hover:text-stone-200 transition">Fragments</a>
            <a href="{{ route('blog.index', ['category' => 'poesie']) }}" class="hover:text-stone-200 transition">Poésie</a>
            <a href="{{ route('blog.index', ['category' => 'philosophie']) }}" class="hover:text-stone-200 transition">Philosophie</a>
            <a href="{{ route('blog.about') }}" class="hover:text-stone-200 transition">À propos</a>
        </div>

        {{-- Menu droit --}}
        <div class="flex items-center gap-4">
            <button onclick="toggleDarkMode()" id="dark-mode-btn"
                    class="text-stone-400 hover:text-stone-200 transition text-lg">☀️</button>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-xs border border-stone-700 text-stone-400 px-3 py-1.5 rounded
                              hover:border-stone-500 hover:text-stone-200 transition">
                        Admin
                    </a>
                @else
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-stone-500">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-stone-600 hover:text-stone-400 transition">
                                Partir
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="text-xs text-stone-400 hover:text-stone-200 transition">
                    Entrer
                </a>
                <a href="{{ route('register') }}"
                   class="text-xs border border-stone-700 text-stone-400 px-3 py-1.5 rounded
                          hover:border-stone-500 hover:text-stone-200 transition">
                    Rejoindre
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- CONTENU --}}
<main class="pt-20">
    @if(session('success'))
        <div class="max-w-5xl mx-auto px-6 mt-4">
            <div class="bg-stone-900 border border-stone-700 text-stone-300 px-4 py-3 rounded text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="mt-24 border-t border-stone-800">
    <div class="max-w-5xl mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row justify-between items-start gap-8">
            <div>
                <div class="font-serif text-xl text-stone-300 mb-2">Le Rouleau Gris</div>
                <p class="text-stone-500 text-sm max-w-sm leading-relaxed">
                    Un carnet numérique mêlant poésie, philosophie, technologie
                    et réflexions personnelles. Archive d'une vie pensante.
                </p>
            </div>
            <div class="flex gap-12 text-sm text-stone-500">
                <div>
                    <div class="text-stone-400 font-medium mb-3">Catégories</div>
                    @foreach(\App\Models\Category::all() as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                       class="block hover:text-stone-300 transition mb-1">{{ $cat->name }}</a>
                    @endforeach
                </div>
                <div>
                    <div class="text-stone-400 font-medium mb-3">Navigation</div>
                    <a href="{{ route('blog.index') }}" class="block hover:text-stone-300 transition mb-1">Fragments</a>
                    <a href="{{ route('blog.about') }}" class="block hover:text-stone-300 transition mb-1">À propos</a>
                    @guest
                    <a href="{{ route('register') }}" class="block hover:text-stone-300 transition mb-1">Rejoindre</a>
                    @endguest
                </div>
            </div>
        </div>
        <div class="mt-10 pt-6 border-t border-stone-900 text-center text-stone-700 text-xs">
            © {{ date('Y') }} Le Rouleau Gris — Tous droits réservés
        </div>
    </div>
</footer>

<script>
    // Barre de progression + bouton retour
    const progressBar = document.getElementById('progress-bar');
    const backToTop   = document.getElementById('back-to-top');

    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        if (progressBar) progressBar.style.width = (docHeight > 0 ? (scrollTop / docHeight) * 100 : 0) + '%';
        if (backToTop) {
            if (scrollTop > 300) {
                backToTop.style.opacity = '1';
            } else {
                backToTop.style.opacity = '0';
            }
        }
    });
</script>

</body>
</html>