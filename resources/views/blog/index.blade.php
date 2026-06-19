@extends('blog.layout')
@section('title', 'Fragments')

@section('content')

{{-- HERO --}}
<section class="relative min-h-screen flex items-end overflow-hidden">

    {{-- Image de fond --}}
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=1400&q=80"
             alt="" class="w-full h-full object-cover opacity-25">
        <div class="absolute inset-0" style="background: linear-gradient(to top, #0e0e0b 30%, rgba(14,14,11,0.7) 70%, rgba(14,14,11,0.4) 100%)"></div>
    </div>

    <div class="relative max-w-6xl mx-auto px-6 py-24 w-full">
        <div class="max-w-2xl fade-up">
            <p class="font-inter text-[10px] tracking-[0.4em] uppercase text-silver/40 mb-6">
                Archive personnelle
            </p>
            <h1 class="font-garamond italic text-7xl md:text-8xl text-parchment mb-6 leading-none">
                Le Rouleau<br>
                <em class="text-silver/60">Gris</em>
            </h1>
            <p class="font-garamond text-xl text-silver/60 leading-relaxed mb-10 max-w-lg">
                Des fragments de poésie, de philosophie, de technologie et de mémoire.
                Écrits dans la solitude, partagés avec discrétion.
            </p>
            <div class="flex items-center gap-6">
                <a href="#fragments"
                   class="font-inter text-xs tracking-[0.2em] uppercase text-parchment/60
                          border-b border-parchment/20 hover:border-parchment/60 pb-1 transition-all duration-500">
                    Lire les fragments
                </a>
                <div class="w-16 h-px bg-silver/20"></div>
                <span class="font-garamond italic text-silver/40 text-sm">
                    {{ \App\Models\Post::where('status','published')->count() }} fragments
                </span>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-30">
        <div class="w-px h-12 bg-silver/40 animate-pulse"></div>
    </div>
</section>

{{-- ARTICLE À LA UNE --}}
@if($featured)
<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-px h-8 bg-silver/30"></div>
        <p class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/40">Fragment en lumière</p>
        <div class="flex-1 h-px bg-white/5"></div>
    </div>

    <a href="{{ route('blog.show', $featured->slug) }}" class="group block">
        <div class="grid md:grid-cols-2 gap-0 border border-white/8 overflow-hidden hover:border-white/15 transition-all duration-700"
             style="background: #131410;">
            {{-- Image --}}
            <div class="relative overflow-hidden h-64 md:h-auto">
                @if($featured->cover_image)
                <img src="{{ Storage::url($featured->cover_image) }}"
                     class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-70 group-hover:scale-105 transition-all duration-1000"
                     alt="{{ $featured->title }}">
                @elseif($featured->category->image_url ?? false)
                <img src="{{ $featured->category->image_url }}"
                     class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-50 group-hover:scale-105 transition-all duration-1000"
                     alt="">
                @else
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="font-garamond italic text-6xl text-white/10">
                        {{ substr($featured->title, 0, 1) }}
                    </span>
                </div>
                @endif
                <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(14,14,11,0.6) 0%, transparent 100%)"></div>
            </div>

            {{-- Contenu --}}
            <div class="p-10 md:p-14 flex flex-col justify-center">
                <span class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/40 mb-4">
                    {{ $featured->category->name ?? '' }}
                </span>
                <h2 class="font-garamond italic text-4xl text-parchment/90 mb-4 leading-tight
                           group-hover:text-white transition duration-500">
                    {{ $featured->title }}
                </h2>
                <p class="font-garamond text-lg text-silver/50 leading-relaxed mb-8">
                    {{ $featured->excerpt ?? Str::limit(strip_tags($featured->content), 160) }}
                </p>
                <div class="flex items-center gap-5 text-[10px] font-inter text-silver/30 tracking-widest uppercase">
                    <span>{{ $featured->created_at->format('d M Y') }}</span>
                    <span class="text-silver/15">·</span>
                    <span>{{ $featured->reading_time }} min</span>
                    <span class="text-silver/15">·</span>
                    <span>{{ $featured->views }} lectures</span>
                </div>
                <div class="mt-6 flex items-center gap-3 text-silver/40 group-hover:text-parchment/60 transition duration-500">
                    <span class="font-inter text-xs tracking-[0.2em] uppercase">Lire</span>
                    <span class="w-8 h-px bg-current"></span>
                </div>
            </div>
        </div>
    </a>
</section>
@endif

{{-- FILTRES --}}
<section id="fragments" class="max-w-6xl mx-auto px-6 mb-10">
    <div class="flex flex-wrap items-center gap-0 border-b border-white/5 pb-0 overflow-x-auto">
        <a href="{{ route('blog.index') }}"
           class="font-inter text-[10px] tracking-[0.2em] uppercase px-5 py-4 transition duration-300
                  border-b-2 {{ !request('category') ? 'border-parchment/60 text-parchment/80' : 'border-transparent text-silver/40 hover:text-silver/60' }}">
            Tout
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
           class="font-inter text-[10px] tracking-[0.2em] uppercase px-5 py-4 transition duration-300
                  border-b-2 {{ request('category') === $cat->slug ? 'border-parchment/60 text-parchment/80' : 'border-transparent text-silver/40 hover:text-silver/60' }}">
            {{ $cat->name }}
            <span class="text-silver/20 ml-1">({{ $cat->posts_count }})</span>
        </a>
        @endforeach
    </div>
</section>

{{-- Recherche active --}}
@if(request('search'))
<div class="max-w-6xl mx-auto px-6 mb-8">
    <p class="font-garamond italic text-silver/40 text-sm">
        « {{ request('search') }} » — {{ $posts->total() }} fragment(s)
        <a href="{{ route('blog.index') }}" class="ml-3 text-silver/30 hover:text-silver/60 transition not-italic font-inter text-xs">
            × effacer
        </a>
    </p>
</div>
@endif

{{-- GRILLE --}}
<section class="max-w-6xl mx-auto px-6 pb-24">
    @if($posts->isEmpty())
    <div class="py-32 text-center">
        <p class="font-garamond italic text-4xl text-silver/20">
            Le silence, parfois, est aussi un fragment.
        </p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $i => $post)
        <article class="card-hover group flex flex-col" style="animation-delay: {{ $i * 0.05 }}s">

            {{-- Image --}}
            <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden h-52 relative flex-shrink-0"
               style="background:#131410;">
                @if($post->cover_image)
                <img src="{{ Storage::url($post->cover_image) }}"
                     class="w-full h-full object-cover opacity-50 group-hover:opacity-70 group-hover:scale-105 transition-all duration-700">
                @elseif($post->category->image_url ?? false)
                <img src="{{ $post->category->image_url }}"
                     class="w-full h-full object-cover opacity-25 group-hover:opacity-40 group-hover:scale-105 transition-all duration-700">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <span class="font-garamond italic text-7xl text-white/5 group-hover:text-white/10 transition">
                        {{ substr($post->title, 0, 1) }}
                    </span>
                </div>
                @endif
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(14,14,11,0.8) 0%, transparent 60%)"></div>
                {{-- Catégorie sur image --}}
                <div class="absolute bottom-3 left-4">
                    <span class="font-inter text-[9px] tracking-[0.25em] uppercase text-silver/50">
                        {{ $post->category->name ?? '' }}
                    </span>
                </div>
            </a>

            {{-- Contenu --}}
            <div class="p-6 flex flex-col flex-1" style="background:#131410;">
                <h2 class="font-garamond italic text-2xl text-parchment/85 mb-3 leading-snug
                           group-hover:text-white transition duration-400 flex-1">
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                </h2>
                <p class="font-garamond text-base text-silver/45 leading-relaxed mb-5 line-clamp-2">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 90) }}
                </p>
                <div class="flex items-center justify-between pt-4 border-t border-white/5">
                    <div class="flex items-center gap-3 font-inter text-[9px] text-silver/30 tracking-widest uppercase">
                        <span>{{ $post->created_at->format('d/m/Y') }}</span>
                        <span class="text-silver/15">·</span>
                        <span>{{ $post->reading_time }} min</span>
                    </div>
                    <div class="flex items-center gap-3 font-inter text-[9px] text-silver/25">
                        <span>{{ $post->views }} ◉</span>
                        <span>{{ $post->likes->count() }} ♡</span>
                        @php $avg = $post->averageRating(); @endphp
                        @if($avg > 0)
                        <span>{{ $avg }} ★</span>
                        @endif
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <div class="mt-16 flex justify-center">
        {{ $posts->links() }}
    </div>
    @endif
</section>

{{-- CTA Rejoindre --}}
@guest
<section class="border-t border-white/5 py-24">
    <div class="max-w-2xl mx-auto px-6 text-center">
        <p class="font-garamond italic text-5xl text-parchment/80 mb-4 leading-tight">
            Rejoignez l'archive
        </p>
        <p class="font-garamond text-lg text-silver/40 mb-10">
            Commentez, réagissez, notez les fragments qui vous touchent.
        </p>
        <a href="{{ route('register') }}"
           class="inline-block font-inter text-xs tracking-[0.2em] uppercase border border-white/20
                  text-parchment/60 px-8 py-4 hover:border-white/40 hover:text-parchment/90 transition-all duration-500">
            Commencer le voyage
        </a>
    </div>
</section>
@endguest

@endsection