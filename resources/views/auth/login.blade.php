<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès — Le Rouleau Gris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
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
                    }
                }
            }
        }
    </script>
    <style>
        .input-line {
            background: transparent;
            border: none;
            border-bottom: 1px solid #2a2a26;
            border-radius: 0;
            padding: 12px 0;
            color: #e5e2db;
            font-family: 'EB Garamond', serif;
            font-size: 1.1rem;
            width: 100%;
            transition: border-color 0.4s ease;
        }
        .input-line::placeholder { color: rgba(229,226,219,0.15); }
        .input-line:focus { outline: none; border-bottom-color: #a0a09a; box-shadow: none; }
        .btn-primary { transition: all 0.4s ease; letter-spacing: 0.15em; }
        .btn-primary:hover { opacity: 0.85; letter-spacing: 0.2em; }

        /* Nib animation */
        .scroll-nib {
            position: absolute;
            right: 0;
            top: 25%;
            bottom: 25%;
            width: 1px;
            background: rgba(160,160,154,0.15);
        }
        .scroll-nib-indicator {
            position: absolute;
            top: 0;
            left: -1px;
            width: 3px;
            height: 80px;
            background: rgba(200,198,197,0.4);
            transition: all 1s ease-out;
        }
        /* Corner accents */
        .corner-tl { position: absolute; top: 2rem; left: 2rem; width: 2rem; height: 2rem; border-top: 1px solid rgba(160,160,154,0.2); border-left: 1px solid rgba(160,160,154,0.2); }
        .corner-br { position: absolute; bottom: 2rem; right: 2rem; width: 2rem; height: 2rem; border-bottom: 1px solid rgba(160,160,154,0.2); border-right: 1px solid rgba(160,160,154,0.2); }
    </style>
</head>
<body class="h-screen bg-surface text-parchment overflow-hidden" style="font-family: 'Inter', sans-serif;">

<main class="flex flex-col md:flex-row h-full w-full">

    {{-- PANNEAU GAUCHE — Image immersive --}}
    <section class="relative w-full md:w-1/2 h-48 md:h-full overflow-hidden flex-shrink-0">
        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&q=80"
             alt="Archive" class="absolute inset-0 w-full h-full object-cover opacity-75">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>

        <div class="absolute bottom-8 left-8 right-8 z-10 hidden md:block">
            <a href="{{ route('blog.index') }}" class="block mb-10">
                <span class="font-garamond italic text-2xl text-parchment/50">Le Rouleau Gris</span>
            </a>
            <h1 class="font-garamond italic text-5xl text-white mb-4 leading-tight">
                Bienvenue dans<br>le Rouleau Gris
            </h1>
            <p class="font-garamond text-lg text-parchment/70 mb-8">
                Les mots oubliés attendent leur lecteur.
            </p>
            <a href="{{ route('register') }}"
               class="font-inter text-xs tracking-[0.3em] uppercase text-parchment/60
                      border-b border-parchment/20 hover:border-parchment/60 pb-1 transition-all duration-500">
                INSCRIPTION
            </a>
        </div>

        {{-- Mobile logo --}}
        <div class="absolute top-4 left-4 md:hidden">
            <a href="{{ route('blog.index') }}" class="font-garamond italic text-xl text-parchment/80">
                Le Rouleau Gris
            </a>
        </div>
    </section>

    {{-- PANNEAU DROIT — Formulaire --}}
    <section class="relative flex flex-col justify-center items-center flex-1 bg-surface px-8 md:px-16 py-10 overflow-y-auto">
        <div class="corner-tl hidden md:block"></div>
        <div class="corner-br hidden md:block"></div>
        <div class="scroll-nib hidden md:block">
            <div class="scroll-nib-indicator" id="scroll-nib"></div>
        </div>

        <div class="w-full max-w-md">

            <header class="mb-10 text-center md:text-left">
                <p class="font-inter text-xs tracking-[0.4em] text-silver/50 uppercase block mb-2">
                    ACCÈS
                </p>
                <div class="w-8 h-px bg-silver/30 mx-auto md:mx-0"></div>
            </header>

            @if(session('banned'))
            <div class="mb-6 border-l-2 border-red-800 pl-3">
                <p class="text-xs font-inter text-red-400/80 font-medium mb-1">Compte suspendu</p>
                <p class="text-xs font-inter text-red-400/60">{{ session('banned') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 text-sm text-red-400/70 font-inter border-l-2 border-red-900 pl-3">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-10" id="login-form">
                @csrf

                <div>
                    <label class="font-inter text-[10px] tracking-[0.25em] text-silver/50 uppercase block mb-2">
                        IDENTIFIANT
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="input-line" placeholder="votre-nom@archive.com">
                </div>

                <div>
                    <div class="flex justify-between items-end mb-2">
                        <label class="font-inter text-[10px] tracking-[0.25em] text-silver/50 uppercase">
                            CLEF DE VOÛTE
                        </label>
                        @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="font-inter text-[10px] text-silver/40 hover:text-silver/70 transition-colors italic">
                            Perdue ?
                        </a>
                        @endif
                    </div>
                    <input type="password" name="password" required
                           class="input-line" placeholder="••••••••">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-3 h-3 bg-transparent border border-silver/30 rounded-none accent-parchment">
                    <label for="remember" class="font-inter text-[10px] text-silver/40 tracking-widest uppercase">
                        Se souvenir
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" id="submit-btn"
                            class="btn-primary w-full bg-parchment text-surface py-4 font-inter text-xs font-bold tracking-[0.2em] uppercase flex items-center justify-center gap-3">
                        <span>OUVRIR L'ARCHIVE</span>
                        <span>→</span>
                    </button>
                </div>
            </form>

            <footer class="mt-10 text-center">
                <a href="{{ route('register') }}"
                   class="font-inter text-xs text-silver/40 hover:text-silver/70 transition-colors
                          border-b border-transparent hover:border-silver/40 pb-1 italic tracking-wide">
                    S'inscrire à l'archive privée
                </a>
            </footer>

            <div class="mt-4 text-center">
                <a href="{{ route('blog.index') }}"
                   class="font-inter text-[10px] text-silver/30 hover:text-silver/50 transition-colors tracking-widest uppercase">
                    ← Retour aux fragments
                </a>
            </div>

        </div>
    </section>

</main>

<script>
    const inputs = document.querySelectorAll('.input-line');
    const nib = document.getElementById('scroll-nib');

    inputs.forEach((input, index) => {
        input.addEventListener('focus', () => {
            if (nib) {
                nib.style.top = `${(index + 1) / inputs.length * 70}%`;
                nib.style.background = 'rgba(200,198,197,0.6)';
            }
        });
        input.addEventListener('blur', () => {
            if (nib) nib.style.background = 'rgba(200,198,197,0.2)';
        });
    });

    // Animation entrée formulaire
    document.querySelectorAll('#login-form > div').forEach((el, i) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(8px)';
        setTimeout(() => {
            el.style.transition = 'all 0.7s ease-out';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 150 + (i * 120));
    });
</script>

</body>
</html>