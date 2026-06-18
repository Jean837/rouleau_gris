@extends('blog.layout')
@section('title', 'À propos')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-20">

    <p class="text-xs text-stone-600 tracking-widest uppercase mb-6">À propos</p>

    <h1 class="font-serif text-5xl text-stone-100 mb-8 leading-tight">
        Le Rouleau Gris
    </h1>

    <div class="w-12 h-px bg-stone-700 mb-12"></div>

    <div class="prose-rouleau text-stone-400 mb-16">
        <p>
            <em class="font-serif text-stone-300">Le Rouleau Gris</em> est un carnet numérique personnel.
            Un espace où s'accumulent, comme des feuillets d'un manuscrit ancien,
            des fragments de pensées, de lectures, de poèmes et de réflexions sur la technologie.
        </p>
        <p>
            L'ambiance voulue est celle d'une bibliothèque ancienne rencontrée un soir de pluie —
            élégante, silencieuse, habitée. Chaque article est un fragment. Chaque lecture, une trace.
        </p>
        <p>
            Ce blog n'est pas un magazine. Ce n'est pas un portfolio. C'est une archive.
            L'archive d'une vie pensante, partagée avec discrétion.
        </p>
    </div>

    {{-- Catégories --}}
    <div class="mb-16">
        <p class="text-xs text-stone-600 tracking-widest uppercase mb-6">Thèmes explorés</p>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach(\App\Models\Category::withCount('posts')->get() as $cat)
            <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
               class="border border-stone-800 p-4 hover:border-stone-700 hover:bg-stone-900 transition group">
                <div class="w-3 h-3 rounded-full mb-3" style="background: {{ $cat->color }}"></div>
                <div class="font-serif text-stone-300 group-hover:text-white transition text-sm">{{ $cat->name }}</div>
                <div class="text-xs text-stone-700 mt-1">{{ $cat->posts_count }} fragment(s)</div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="border-t border-stone-800 pt-10">
        <a href="{{ route('blog.index') }}"
           class="text-xs text-stone-600 tracking-widest uppercase hover:text-stone-400 transition">
            ← Retour aux fragments
        </a>
    </div>

</div>
@endsection