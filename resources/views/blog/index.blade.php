@extends('blog.layout')
@section('title', 'Fragments')

@section('content')

{{-- HERO --}}
<section class="max-w-5xl mx-auto px-6 py-20">
    <div class="max-w-2xl">
        <p class="text-stone-600 text-xs tracking-widest uppercase mb-6">Archive de pensées</p>
        <h1 class="font-serif text-5xl md:text-6xl text-stone-100 mb-6 leading-tight">
            Le Rouleau<br><em class="text-stone-400">Gris</em>
        </h1>
        <p class="text-stone-400 text-lg leading-relaxed mb-8">
            Un carnet numérique. Des fragments de poésie, de philosophie,
            de technologie et de mémoire. Écrits dans la solitude, partagés avec discrétion.
        </p>
        <div class="w-12 h-px bg-stone-700"></div>
    </div>
</section>

{{-- ARTICLE À LA UNE --}}
@if($featured)
<section class="max-w-5xl mx-auto px-6 mb-16">
    <p class="text-stone-600 text-xs tracking-widest uppercase mb-6">Fragment en lumière</p>
    <a href="{{ route('blog.show', $featured->slug) }}"
       class="group block bg-stone-900 border border-stone-800 rounded-sm overflow-hidden
              hover:border-stone-700 transition-all duration-500">
        <div class="md:flex">
            @if($featured->cover_image)
            <div class="md:w-2/5 overflow-hidden">
                <img src="{{ Storage::url($featured->cover_image) }}"
                     class="w-full h-64 md:h-full object-cover opacity-60 group-hover:opacity-80 transition-all duration-700">
            </div>
            @endif
            <div class="p-8 md:p-12 flex flex-col justify-center {{ $featured->cover_image ? 'md:w-3/5' : 'w-full' }}">
                <span class="text-xs tracking-widest uppercase text-stone-500 mb-4">
                    {{ $featured->category->name ?? '' }}
                </span>
                <h2 class="font-serif text-3xl text-stone-100 mb-4 leading-tight group-hover:text-white transition">
                    {{ $featured->title }}
                </h2>
                <p class="text-stone-400 leading-relaxed mb-6">
                    {{ $featured->excerpt ?? Str::limit(strip_tags($featured->content), 200) }}
                </p>
                <div class="flex items-center gap-4 text-xs text-stone-600">
                    <span>{{ $featured->created_at->format('d M Y') }}</span>
                    <span>·</span>
                    <span>{{ $featured->reading_time }} min</span>
                    <span>·</span>
                    <span>{{ $featured->views }} lectures</span>
                </div>
            </div>
        </div>
    </a>
</section>
@endif

{{-- FILTRES --}}
<section class="max-w-5xl mx-auto px-6 mb-10">
    <div class="flex flex-wrap gap-3 border-b border-stone-800 pb-6">
        <a href="{{ route('blog.index') }}"
           class="text-xs tracking-widest uppercase px-4 py-2 transition
                  {{ !request('category') ? 'text-stone-200 border-b-2 border-stone-400' : 'text-stone-600 hover:text-stone-400' }}">
            Tout
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
           class="text-xs tracking-widest uppercase px-4 py-2 transition
                  {{ request('category') === $cat->slug ? 'text-stone-200 border-b-2 border-stone-400' : 'text-stone-600 hover:text-stone-400' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>
</section>

{{-- RECHERCHE --}}
@if(request('search'))
<div class="max-w-5xl mx-auto px-6 mb-6">
    <p class="text-stone-500 text-sm">
        Résultats pour « {{ request('search') }} » — {{ $posts->total() }} fragment(s)
        <a href="{{ route('blog.index') }}" class="text-stone-600 hover:text-stone-400 ml-2 transition">× effacer</a>
    </p>
</div>
@endif

{{-- GRILLE --}}
<section class="max-w-5xl mx-auto px-6 pb-20">
    @if($posts->isEmpty())
    <div class="text-center py-20">
        <p class="font-serif text-2xl text-stone-600 italic">Le silence, parfois, est aussi un fragment.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($posts as $post)
        <article class="group border border-stone-800 bg-stone-900/50 hover:bg-stone-900 hover:border-stone-700
                        transition-all duration-500 flex flex-col">

            {{-- Image --}}
            @if($post->cover_image)
            <a href="{{ route('blog.show', $post->slug) }}" class="overflow-hidden h-48 block">
                <img src="{{ Storage::url($post->cover_image) }}"
                     class="w-full h-full object-cover opacity-50 group-hover:opacity-70 transition-all duration-700">
            </a>
            @elseif($post->category->image_url)
            <a href="{{ route('blog.show', $post->slug) }}" class="overflow-hidden h-48 block">
                <img src="{{ $post->category->image_url }}"
                     class="w-full h-full object-cover opacity-30 group-hover:opacity-50 transition-all duration-700">
            </a>
            @endif

            <div class="p-6 flex flex-col flex-1">
                <span class="text-xs tracking-widest uppercase text-stone-600 mb-3">
                    {{ $post->category->name ?? '' }}
                </span>
                <h2 class="font-serif text-xl text-stone-200 mb-3 leading-snug
                           group-hover:text-white transition flex-1">
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                </h2>
                <p class="text-stone-500 text-sm leading-relaxed mb-4">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                </p>
                <div class="flex items-center justify-between text-xs text-stone-700 pt-4 border-t border-stone-800">
                    <div class="flex items-center gap-3">
                        <span>{{ $post->created_at->format('d/m/Y') }}</span>
                        <span>{{ $post->reading_time }} min</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span>{{ $post->views }} 👁</span>
                        <span>{{ $post->likes->count() }} ♡</span>
                        @php $avg = $post->averageRating(); @endphp
                        @if($avg > 0)
                        <span>{{ $avg }}★</span>
                        @endif
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    <div class="mt-12 flex justify-center">
        {{ $posts->links() }}
    </div>
    @endif
</section>

@endsection