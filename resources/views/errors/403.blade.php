<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Accès refusé — Le Rouleau Gris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
</head>
<body class="min-h-screen bg-stone-950 flex items-center justify-center p-6">
<div class="text-center max-w-md">
    <div class="text-stone-800 text-8xl font-light mb-6">403</div>
    <h1 class="text-stone-400 text-xl mb-4">Accès refusé</h1>
    <p class="text-stone-600 text-sm mb-8">Vous n'avez pas les droits pour accéder à cette page.</p>
    <a href="{{ route('blog.index') }}"
       class="text-xs text-stone-600 border border-stone-800 px-4 py-2 hover:border-stone-700 hover:text-stone-400 transition">
        ← Retour aux fragments
    </a>
</div>
</body>
</html>