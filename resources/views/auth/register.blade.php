<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejoindre l'Archive — Le Rouleau Gris</title>
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
                        border: '#2a2a26',
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
        .btn-primary {
            transition: all 0.4s ease;
            letter-spacing: 0.15em;
        }
        .btn-primary:hover { opacity: 0.85; letter-spacing: 0.2em; }
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
    </style>
</head>
<body class="h-screen bg-surface text-parchment overflow-hidden">

<main class="flex flex-col md:flex-row h-full w-full">

    {{-- PANNEAU GAUCHE — Image immersive --}}
    <section class="relative w-full md:w-1/2 h-48 md:h-full overflow-hidden flex-shrink-0">
        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=800&q=80"
             alt="Archive" class="absolute inset-0 w-full h-full object-cover opacity-70">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
        <div class="absolute bottom-8 left-8 right-8 z-10 hidden md:block">
            <a href="{{ route('blog.index') }}" class="block mb-8">
                <span class="font-garamond italic text-2xl text-parchment/60">Le Rouleau Gris</span>
            </a>
            <h1 class="font-garamond italic text-5xl text-parchment mb-4 leading-tight">
                Commence ton voyage
            </h1>
            <p class="font-garamond italic text-lg text-parchment/70">
                Chaque âme laisse une trace sur le rouleau.
            </p>
        </div>
        {{-- Mobile logo --}}
        <div class="absolute top-4 left-4 md:hidden">
            <a href="{{ route('blog.index') }}" class="font-garamond italic text-xl text-parchment/80">
                Le Rouleau Gris
            </a>
        </div>
    </section>

    {{-- PANNEAU DROIT — Formulaire --}}
    <section class="flex flex-col justify-center items-center flex-1 bg-surface px-8 md:px-16 py-10 overflow-y-auto">
        <div class="w-full max-w-md">

            <header class="mb-10">
                <p class="font-inter text-xs tracking-[0.3em] text-silver/60 uppercase mb-2">
                    REJOINDRE L'ARCHIVE
                </p>
                <div class="w-8 h-px bg-silver/30"></div>
            </header>

            @if($errors->any())
            <div class="mb-6 text-sm text-red-400/80 font-inter border-l-2 border-red-800 pl-3">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-8">
                @csrf

                <div>
                    <label class="font-inter text-[10px] tracking-[0.25em] text-silver/50 uppercase block mb-2">
                        NOM / PSEUDONYME
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="input-line" placeholder="Saisissez votre nom...">
                </div>

                <div>
                    <label class="font-inter text-[10px] tracking-[0.25em] text-silver/50 uppercase block mb-2">
                        CLEF D'ACCÈS (EMAIL)
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="input-line" placeholder="votre@âme.com">
                    <p class="text-[10px] text-silver/30 mt-1 font-inter">Un code de confirmation sera envoyé</p>
                </div>

                <div>
                    <label class="font-inter text-[10px] tracking-[0.25em] text-silver/50 uppercase block mb-2">
                        SECRET DE L'ESPRIT
                    </label>
                    <input type="password" name="password" required
                           class="input-line" placeholder="••••••••">
                </div>

                <div>
                    <label class="font-inter text-[10px] tracking-[0.25em] text-silver/50 uppercase block mb-2">
                        CONFIRMER LE SECRET
                    </label>
                    <input type="password" name="password_confirmation" required
                           class="input-line" placeholder="••••••••">
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="btn-primary w-full bg-parchment text-surface py-4 font-inter text-xs font-bold tracking-[0.2em] uppercase">
                        S'INSCRIRE
                    </button>
                </div>
            </form>

            <footer class="mt-8 text-center">
                <p class="font-inter text-xs text-silver/40 tracking-wide">
                    Déjà initié ?
                    <a href="{{ route('login') }}" class="text-parchment/70 hover:text-parchment transition-colors ml-2 underline underline-offset-4">
                        Se connecter
                    </a>
                </p>
            </footer>

        </div>
    </section>

</main>

</body>
</html>