<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration — Le Rouleau Gris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { fontFamily: { garamond: ['"EB Garamond"', 'serif'], inter: ['Inter', 'sans-serif'] } } } }</script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .garamond { font-family: 'EB Garamond', serif; }
        body { background: #0e0e0b; color: #e5e2db; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #0e0e0b; }
        ::-webkit-scrollbar-thumb { background: #2a2a26; }
        .nav-link { transition: all 0.3s ease; }
        .nav-link:hover { color: #e5e2db; padding-left: 0.5rem; }
        .nav-link.active { color: #a0a09a; border-left: 1px solid #3a3935; padding-left: 0.75rem; }
        .input-admin {
            background: transparent;
            border: 1px solid #1c1c18;
            color: #e5e2db;
            padding: 10px 14px;
            font-size: 0.875rem;
            width: 100%;
            transition: border-color 0.3s;
        }
        .input-admin:focus { outline: none; border-color: #3a3935; }
        .btn-admin {
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            border: 1px solid #2a2a26;
            color: #a0a09a;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-admin:hover { border-color: #4a4a46; color: #e5e2db; }
        .btn-admin-primary {
            background: #e5e2db;
            color: #0e0e0b;
            border: none;
        }
        .btn-admin-primary:hover { opacity: 0.85; }
    </style>
</head>
<body class="min-h-screen">
<div class="flex">

    {{-- SIDEBAR --}}
    <aside class="w-52 min-h-screen fixed flex flex-col py-8 px-6 border-r"
           style="background:#0a0a08; border-color:#1a1a17;">

        <div class="mb-10">
            <div class="garamond italic text-xl text-parchment/70 leading-tight">Le Rouleau</div>
            <div class="garamond italic text-xl text-silver/40 leading-tight">Gris</div>
            <div class="text-[9px] tracking-[0.3em] uppercase text-silver/25 mt-1">Administration</div>
        </div>

        <nav class="flex-1 space-y-0.5">
            <a href="{{ route('blog.index') }}"
               class="nav-link block text-xs text-silver/35 py-2 hover:text-silver/60">
                → Voir le blog
            </a>

            <div class="pt-4 pb-2">
                <span class="text-[9px] tracking-[0.3em] uppercase text-silver/20">Contenu</span>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link block text-xs text-silver/50 py-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Tableau de bord
            </a>
            <a href="{{ route('admin.posts.index') }}"
               class="nav-link block text-xs text-silver/50 py-2 {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                Fragments
            </a>
            <a href="{{ route('admin.posts.create') }}"
               class="nav-link block text-xs text-silver/35 py-2">
                + Nouveau
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link block text-xs text-silver/50 py-2 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                Catégories
            </a>

            <div class="pt-4 pb-2">
                <span class="text-[9px] tracking-[0.3em] uppercase text-silver/20">Communauté</span>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="nav-link block text-xs text-silver/50 py-2 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                Utilisateurs
            </a>
        </nav>

        <div class="border-t pt-5 mt-auto" style="border-color:#1a1a17;">
            <div class="text-[10px] text-silver/30 mb-1 truncate">{{ auth()->user()->name }}</div>
            <div class="text-[9px] text-silver/20 mb-3 truncate">{{ auth()->user()->email }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[9px] tracking-[0.2em] uppercase text-silver/25
                                             hover:text-silver/50 transition">
                    Partir
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENU --}}
    <main class="ml-52 flex-1 p-10 min-h-screen">

        @if(session('success'))
        <div class="border-l-2 border-silver/30 pl-3 py-2 text-xs text-silver/50 font-inter mb-6">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="border-l-2 border-red-800/50 pl-3 py-2 text-xs text-red-400/60 font-inter mb-6">
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>