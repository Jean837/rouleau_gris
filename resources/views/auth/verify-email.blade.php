<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification — Le Rouleau Gris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { fontFamily: { garamond: ['"EB Garamond"', 'serif'], inter: ['Inter', 'sans-serif'] } } } }</script>
    <style>
        body { background: #0e0e0b; color: #e5e2db; font-family: 'Inter', sans-serif; }
        .input-code {
            background: transparent;
            border: none;
            border-bottom: 2px solid #3a3935;
            color: #e5e2db;
            font-family: 'EB Garamond', serif;
            font-size: 2.5rem;
            text-align: center;
            letter-spacing: 0.5em;
            padding: 8px 0;
            width: 100%;
            transition: border-color 0.3s;
        }
        .input-code:focus { outline: none; border-bottom-color: #a0a09a; }
        .btn { transition: all 0.4s ease; letter-spacing: 0.15em; }
        .btn:hover { opacity: 0.85; letter-spacing: 0.2em; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-sm">

    {{-- Logo --}}
    <div class="text-center mb-12">
        <a href="{{ route('blog.index') }}">
            <span class="font-garamond italic text-3xl text-parchment/60">Le Rouleau Gris</span>
        </a>
    </div>

    {{-- Séparateur --}}
    <div class="flex items-center gap-4 mb-10">
        <div class="flex-1 h-px bg-white/10"></div>
        <span class="font-inter text-[10px] tracking-[0.3em] text-white/30 uppercase">Vérification</span>
        <div class="flex-1 h-px bg-white/10"></div>
    </div>

    <p class="font-garamond italic text-xl text-center text-parchment/70 mb-2">
        Un code vous a été envoyé
    </p>
    <p class="font-inter text-xs text-center text-silver/40 mb-10">
        {{ Auth::user()->email }}
    </p>

    @if(session('success'))
    <div class="mb-6 text-center text-xs text-green-400/70 font-inter border border-green-900/50 py-2">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 text-center text-xs text-red-400/70 font-inter border-l-2 border-red-900 pl-3">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('verify.email') }}" class="mb-8">
        @csrf
        <input type="text" name="code" maxlength="6" autofocus
               class="input-code mb-8" placeholder="000000">
        <button type="submit"
                class="btn w-full bg-parchment text-surface py-4 font-inter text-xs font-bold tracking-[0.2em] uppercase">
            CONFIRMER L'ACCÈS
        </button>
    </form>

    <div class="text-center">
        <form method="POST" action="{{ route('verify.email.resend') }}">
            @csrf
            <button type="submit"
                    class="font-inter text-[10px] text-silver/30 hover:text-silver/60 transition-colors
                           tracking-widest uppercase underline underline-offset-4">
                Renvoyer un code
            </button>
        </form>
    </div>

</div>

</body>
</html>