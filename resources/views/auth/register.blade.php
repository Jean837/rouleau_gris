<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejoindre — Le Rouleau Gris</title>
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
                "Rejoindre Le Rouleau Gris, c'est entrer dans une archive privée de pensées
                et de connaissances. Bienvenue."
            </p>
            <div class="flex flex-col gap-3 text-sm text-stone-600">
                <div class="flex items-center gap-3">
                    <span class="w-px h-4 bg-stone-700"></span>
                    Accès aux fragments publiés
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-px h-4 bg-stone-700"></span>
                    Possibilité de commenter et réagir
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-px h-4 bg-stone-700"></span>
                    Confirmation par email requise
                </div>
            </div>
        </div>
    </div>

    {{-- Panneau droit --}}
    <div class="w-full md:w-1/2 p-10 border border-stone-800">

        <h1 style="font-family: 'Playfair Display', serif" class="text-2xl text-stone-200 mb-2">
            Rejoindre l'archive
        </h1>
        <p class="text-stone-600 text-sm mb-8">
            Déjà membre ?
            <a href="{{ route('login') }}" class="text-stone-400 hover:text-stone-200 transition underline">
                Entrer
            </a>
        </p>

        @if($errors->any())
        <div class="border border-stone-700 text-stone-400 px-4 py-3 text-sm mb-6">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Nom</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full bg-transparent border border-stone-800 text-stone-300 px-4 py-3 text-sm
                              focus:outline-none focus:border-stone-600 transition placeholder-stone-700"
                       placeholder="Votre nom">
            </div>
            <div>
                <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full bg-transparent border border-stone-800 text-stone-300 px-4 py-3 text-sm
                              focus:outline-none focus:border-stone-600 transition placeholder-stone-700"
                       placeholder="votre@email.com">
                <p class="text-xs text-stone-700 mt-1">Un code de confirmation sera envoyé</p>
            </div>
            <div>
                <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Mot de passe</label>
                <input type="password" name="password" required
                       class="w-full bg-transparent border border-stone-800 text-stone-300 px-4 py-3 text-sm
                              focus:outline-none focus:border-stone-600 transition"
                       placeholder="Minimum 8 caractères">
            </div>
            <div>
                <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Confirmer</label>
                <input type="password" name="password_confirmation" required
                       class="w-full bg-transparent border border-stone-800 text-stone-300 px-4 py-3 text-sm
                              focus:outline-none focus:border-stone-600 transition"
                       placeholder="••••••••">
            </div>
            <button type="submit"
                    class="w-full border border-stone-700 text-stone-400 py-3 text-sm tracking-widest uppercase
                           hover:border-stone-500 hover:text-stone-200 transition mt-2">
                Rejoindre
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