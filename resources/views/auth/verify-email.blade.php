<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification — Le Rouleau Gris</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@0;1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
</head>
<body class="min-h-screen bg-stone-950 flex items-center justify-center p-6">

<div class="w-full max-w-md border border-stone-800 p-10">

    <a href="{{ route('blog.index') }}" class="flex flex-col leading-none mb-10">
        <span style="font-family: 'Playfair Display', serif" class="text-xl text-stone-200">Le Rouleau</span>
        <span style="font-family: 'Playfair Display', serif" class="text-xl text-stone-500 italic">Gris</span>
    </a>

    <h1 style="font-family: 'Playfair Display', serif" class="text-2xl text-stone-200 mb-2">
        Vérification
    </h1>
    <p class="text-stone-600 text-sm mb-8">
        Un code à 6 chiffres a été envoyé à<br>
        <span class="text-stone-400">{{ Auth::user()->email }}</span>
    </p>

    @if(session('success'))
    <div class="border border-stone-700 text-stone-400 px-4 py-3 text-sm mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="border border-red-900 text-red-500 px-4 py-3 text-sm mb-6">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('verify.email') }}" class="mb-6">
        @csrf
        <input type="text" name="code" maxlength="6" autofocus
               class="w-full bg-transparent border border-stone-800 text-stone-200 px-4 py-4
                      text-center text-3xl tracking-widest font-mono focus:outline-none
                      focus:border-stone-600 transition placeholder-stone-800 mb-4"
               placeholder="000000">
        <button type="submit"
                class="w-full border border-stone-700 text-stone-400 py-3 text-sm tracking-widest uppercase
                       hover:border-stone-500 hover:text-stone-200 transition">
            Confirmer
        </button>
    </form>

    <form method="POST" action="{{ route('verify.email.resend') }}" class="text-center">
        @csrf
        <button type="submit" class="text-xs text-stone-700 hover:text-stone-500 transition underline">
            Renvoyer un code
        </button>
    </form>

</div>

</body>
</html>