<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration — Le Rouleau Gris</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@0;1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
</head>
<body class="bg-stone-950 text-stone-300 min-h-screen">
<div class="flex">

    {{-- Sidebar --}}
    <aside class="w-56 min-h-screen bg-stone-900 border-r border-stone-800 fixed flex flex-col p-6">
        <div class="mb-10">
            <div style="font-family:'Playfair Display',serif" class="text-stone-200 text-lg">Le Rouleau</div>
            <div style="font-family:'Playfair Display',serif" class="text-stone-500 italic text-lg">Gris</div>
            <div class="text-xs text-stone-700 mt-1 tracking-widest uppercase">Administration</div>
        </div>

        <nav class="space-y-1 flex-1 text-sm">
            <a href="{{ route('blog.index') }}" class="block text-stone-600 hover:text-stone-300 py-2 transition">
                → Voir le blog
            </a>
            <div class="w-full h-px bg-stone-800 my-3"></div>
            <a href="{{ route('admin.dashboard') }}"
               class="block py-2 transition {{ request()->routeIs('admin.dashboard') ? 'text-stone-200' : 'text-stone-600 hover:text-stone-300' }}">
                Tableau de bord
            </a>
            <a href="{{ route('admin.posts.index') }}"
               class="block py-2 transition {{ request()->routeIs('admin.posts.*') ? 'text-stone-200' : 'text-stone-600 hover:text-stone-300' }}">
                Fragments
            </a>
            <a href="{{ route('admin.posts.create') }}"
               class="block py-2 transition text-stone-600 hover:text-stone-300">
                + Nouveau fragment
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="block py-2 transition {{ request()->routeIs('admin.categories.*') ? 'text-stone-200' : 'text-stone-600 hover:text-stone-300' }}">
                Catégories
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="block py-2 transition {{ request()->routeIs('admin.users.*') ? 'text-stone-200' : 'text-stone-600 hover:text-stone-300' }}">
                Utilisateurs
            </a>
        </nav>

        <div class="mt-auto">
            <div class="text-xs text-stone-700 mb-3">{{ auth()->user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-stone-700 hover:text-stone-500 transition">
                    Partir
                </button>
            </form>
        </div>
    </aside>

    {{-- Contenu --}}
    <main class="ml-56 flex-1 p-10">
        @if(session('success'))
        <div class="border border-stone-700 text-stone-400 px-4 py-3 text-sm mb-6">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="border border-red-900 text-red-500 px-4 py-3 text-sm mb-6">
            {{ session('error') }}
        </div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>