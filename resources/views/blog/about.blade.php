@extends('blog.layout')
@section('title', 'L\'Archive')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-24">

    <p class="font-inter text-[10px] tracking-[0.4em] uppercase text-silver/30 mb-8">L'archive</p>

    <h1 class="font-garamond italic text-6xl text-parchment/90 mb-8 leading-tight">
        Le Rouleau Gris
    </h1>

    <div class="w-12 h-px bg-silver/20 mb-14"></div>

    <div class="font-garamond text-xl text-silver/60 leading-loose space-y-6 mb-16">
        <p>
            <em class="text-parchment/80">Le Rouleau Gris</em> est un carnet numérique personnel.
            Un espace où s'accumulent, comme des feuillets d'un manuscrit ancien,
            des fragments de pensées, de lectures, de poèmes et de réflexions.
        </p>
        <p>
            L'ambiance voulue est celle d'une bibliothèque ancienne rencontrée un soir de pluie —
            élégante, silencieuse, habitée. Chaque article est un fragment.
            Chaque lecture, une trace.
        </p>
        <p>
            Ce blog n'est pas un magazine. Ce n'est pas un portfolio.
            C'est une archive. L'archive d'une vie pensante.
        </p>
    </div>

    {{-- Catégories --}}
    <div class="mb-16">
        <p class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-8">
            Thèmes explorés
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach(\App\Models\Category::withCount('posts')->get() as $cat)
            <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
               class="group flex items-center gap-4 border border-white/6 p-5
                      hover:border-white/15 transition-all duration-500"
               style="background:#131410;">
                <div class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $cat->color }}"></div>
                <div>
                    <div class="font-garamond italic text-xl text-parchment/70 group-hover:text-white transition">
                        {{ $cat->name }}
                    </div>
                    <div class="font-inter text-[10px] text-silver/30 tracking-widest uppercase mt-0.5">
                        {{ $cat->posts_count }} fragment(s)
                    </div>
                </div>
                <span class="ml-auto text-silver/20 group-hover:text-silver/50 transition text-lg">→</span>
            </a>
            @endforeach
        </div>
    </div>

    <div class="border-t border-white/5 pt-10">
        <a href="{{ route('blog.index') }}"
           class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/30
                  hover:text-silver/60 transition border-b border-transparent hover:border-silver/30 pb-1">
            ← Retour aux fragments
        </a>
    </div>

</div>
@endsection