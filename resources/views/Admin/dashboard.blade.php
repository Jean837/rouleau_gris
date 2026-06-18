@extends('admin.layout')
@section('content')

<h1 style="font-family:'Playfair Display',serif" class="text-2xl text-stone-200 mb-8">
    Tableau de bord
</h1>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    @foreach([
        ['Fragments publiés', $stats['published_posts'], $stats['draft_posts'] . ' brouillon(s)'],
        ['Vues totales', number_format($stats['total_views']), 'tous fragments'],
        ['Commentaires', $stats['total_comments'], $stats['total_reports'] . ' signalement(s)'],
        ['Utilisateurs', $stats['total_users'], $stats['total_categories'] . ' catégories'],
    ] as [$label, $value, $sub])
    <div class="border border-stone-800 p-5">
        <div class="text-xs text-stone-600 tracking-widest uppercase mb-2">{{ $label }}</div>
        <div class="text-3xl text-stone-200 font-light mb-1">{{ $value }}</div>
        <div class="text-xs text-stone-700">{{ $sub }}</div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-2 gap-8 mb-10">

    {{-- Top articles --}}
    <div class="border border-stone-800 p-6">
        <div class="text-xs text-stone-600 tracking-widest uppercase mb-5">Top fragments</div>
        <div class="space-y-4">
            @foreach($topPosts as $i => $post)
            <div class="flex items-center gap-3">
                <span class="text-stone-700 text-xs w-4">{{ $i + 1 }}</span>
                <div class="flex-1 min-w-0">
                    <div class="text-stone-300 text-sm truncate">{{ $post->title }}</div>
                    <div class="text-stone-700 text-xs">{{ $post->views }} lectures</div>
                </div>
                <a href="{{ route('admin.posts.edit', $post) }}"
                   class="text-xs text-stone-600 hover:text-stone-400 transition">éditer</a>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Articles par catégorie --}}
    <div class="border border-stone-800 p-6">
        <div class="text-xs text-stone-600 tracking-widest uppercase mb-5">Par catégorie</div>
        <div class="space-y-3">
            @foreach($postsByCategory as $cat)
            @php $percent = $stats['total_posts'] > 0 ? ($cat->posts_count / $stats['total_posts']) * 100 : 0; @endphp
            <div class="flex items-center gap-3">
                <span class="text-stone-500 text-xs w-24 truncate">{{ $cat->name }}</span>
                <div class="flex-1 bg-stone-900 h-1">
                    <div class="h-1 transition-all" style="width:{{ $percent }}%; background:{{ $cat->color }}"></div>
                </div>
                <span class="text-stone-700 text-xs w-4">{{ $cat->posts_count }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Signalements --}}
@if($reportedComments->count() > 0)
<div class="border border-stone-800 p-6">
    <div class="text-xs text-stone-600 tracking-widest uppercase mb-5">
        Commentaires signalés
        <span class="ml-2 text-red-700">{{ $reportedComments->count() }}</span>
    </div>
    <div class="space-y-4">
        @foreach($reportedComments as $commentId => $reports)
        @php $comment = $reports->first()->comment; @endphp
        @if($comment)
        <div class="border border-stone-800 p-4">
            <div class="text-sm text-stone-400 mb-2">
                <span class="text-stone-300">{{ $comment->user->name ?? '?' }}</span>
                <span class="text-stone-700 ml-2">sur "{{ Str::limit($comment->post->title ?? '', 40) }}"</span>
            </div>
            <p class="text-stone-600 text-xs mb-3 italic">"{{ Str::limit($comment->content, 100) }}"</p>
            <div class="text-xs text-stone-700 mb-3">
                {{ $reports->count() }} signalement(s) :
                {{ $reports->pluck('reason')->unique()->implode(', ') }}
            </div>
            <div class="flex gap-3">
                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-700 hover:text-red-500 transition">Supprimer</button>
                </form>
                <form method="POST" action="{{ route('admin.comments.dismiss-reports', $comment) }}">
                    @csrf
                    <button class="text-xs text-stone-600 hover:text-stone-400 transition">Ignorer</button>
                </form>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endif

@endsection