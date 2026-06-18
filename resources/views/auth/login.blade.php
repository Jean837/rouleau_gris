<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrer — Le Rouleau Gris</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@0;1&family=Inter:wght@300;400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
</head>
<body class="min-h-screen bg-stone-950 flex items-center justify-center p-6">

<div class="w-full max-w-4xl flex">

    {{-- Panneau gauche --}}
    <div class="hidden md:flex md:w-1/2 flex-col justify-between p-12 border border-stone-800 border-r-0">
        <a href="{{ route('blog.index') }}" class="flex flex-col leading-none">
            <span style="font-family: 'Playfair Display', serif" class="text-2xl text-stone-200">Le Rouleau</span>
            <span style="font-family: 'Playfair Display', serif" class="text-2xl text-stone-500 italic">Gris</span>
        </a>
        <div>
            <p style="font-family: 'Playfair Display', serif" class="text-stone-400 text-xl italic leading-relaxed mb-6">
                "Entrer dans Le Rouleau Gris, c'est entrer dans une bibliothèque privée.<br>
                Chaque page est un fragment de mémoire."
            </p>
            <div class="w-8 h-px bg-stone-700"></div>
        </div>
    </div>

    {{-- Panneau droit --}}
    <div class="w-full md:w-1/2 p-10 border border-stone-800">

        <h1 style="font-family: 'Playfair Display', serif" class="text-2xl text-stone-200 mb-2">
            Entrer
        </h1>
        <p class="text-stone-600 text-sm mb-8">
            Pas encore membre ?
            <a href="{{ route('register') }}" class="text-stone-400 hover:text-stone-200 transition underline">
                Rejoindre l'archive
            </a>
        </p>

        @if(session('banned'))
        <div class="border border-red-900 bg-red-950/50 text-red-400 px-4 py-3 text-sm mb-6">
            <div class="font-medium mb-1">Compte suspendu</div>
            <p>Raison : {{ session('banned') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="border border-stone-700 text-stone-400 px-4 py-3 text-sm mb-6">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full bg-transparent border border-stone-800 text-stone-300 px-4 py-3 text-sm
                              focus:outline-none focus:border-stone-600 transition placeholder-stone-700"
                       placeholder="votre@email.com">
            </div>
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="text-xs text-stone-600 tracking-widest uppercase">Mot de passe</label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-stone-600 hover:text-stone-400 transition">
                        Oublié ?
                    </a>
                    @endif
                </div>
                <input type="password" name="password" required
                       class="w-full bg-transparent border border-stone-800 text-stone-300 px-4 py-3 text-sm
                              focus:outline-none focus:border-stone-600 transition"
                       placeholder="••••••••">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="accent-stone-500">
                <label for="remember" class="text-xs text-stone-600">Se souvenir de moi</label>
            </div>
            <button type="submit"
                    class="w-full border border-stone-700 text-stone-400 py-3 text-sm tracking-widest uppercase
                           hover:border-stone-500 hover:text-stone-200 transition mt-2">
                Entrer
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('blog.index') }}" class="text-xs text-stone-700 hover:text-stone-500 transition">
                ← Retour aux fragments
            </a>
        </div>
    </div>
</div>

</body>
</html>