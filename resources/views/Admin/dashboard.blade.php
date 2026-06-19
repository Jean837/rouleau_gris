@extends('admin.layout')
@section('content')

<div class="mb-10">
    <p class="text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-2">Vue d'ensemble</p>
    <h1 class="garamond italic text-4xl text-parchment/80">Tableau de bord</h1>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
    @foreach([
        ['Fragments publiés', $stats['published_posts'], $stats['draft_posts'] . ' brouillon(s)', '#a0a09a'],
        ['Lectures totales', number_format($stats['total_views']), 'tous fragments', '#6b7280'],
        ['Réflexions', $stats['total_comments'], $stats['total_reports'] . ' signalement(s)', '#4b5563'],
        ['Initiés', $stats['total_users'], $stats['total_categories'] . ' catégories', '#374151'],
    ] as [$label, $value, $sub, $accent])
    <div class="border p-6 relative overflow-hidden" style="border-color:#1c1c18; background:#0a0a08;">
        <div class="absolute top-0 left-0 w-0.5 h-full" style="background:{{ $accent }}; opacity:0.3;"></div>
        <div class="text-[9px] tracking-[0.3em] uppercase text-silver/30 mb-2">{{ $label }}</div>
        <div class="garamond text-4xl text-parchment/70 mb-1">{{ $value }}</div>
        <div class="text-[10px] text-silver/20">{{ $sub }}</div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-2 gap-8 mb-12">

    {{-- Top fragments --}}
    <div class="border p-6" style="border-color:#1c1c18; background:#0a0a08;">
        <p class="text-[9px] tracking-[0.3em] uppercase text-silver/25 mb-6">Top fragments</p>
        <div class="space-y-5">
            @foreach($topPosts as $i => $post)
            <div class="flex items-start gap-4">
                <span class="garamond italic text-2xl text-silver/20 w-6 flex-shrink-0">{{ $i + 1 }}</span>
                <div class="flex-1 min-w-0">
                    <div class="text-sm text-parchment/60 truncate garamond italic">{{ $post->title }}</div>
                    <div class="text-[10px] text-silver/25 mt-0.5">{{ $post->views }} lectures</div>
                </div>
                <a href="{{ route('admin.posts.edit', $post) }}"
                   class="text-[9px] tracking-widest uppercase text-silver/25 hover:text-silver/50 transition flex-shrink-0">
                    éditer
                </a>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Par catégorie --}}
    <div class="border p-6" style="border-color:#1c1c18; background:#0a0a08;">
        <p class="text-[9px] tracking-[0.3em] uppercase text-silver/25 mb-6">Par catégorie</p>
        <div class="space-y-4">
            @foreach($postsByCategory as $cat)
            @php $percent = $stats['total_posts'] > 0 ? ($cat->posts_count / $stats['total_posts']) * 100 : 0; @endphp
            <div class="flex items-center gap-4">
                <div class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $cat->color }}; opacity:0.6;"></div>
                <span class="text-[10px] text-silver/40 w-24 truncate">{{ $cat->name }}</span>
                <div class="flex-1 h-px" style="background:#1a1a17;">
                    <div class="h-full transition-all duration-1000"
                         style="width:{{ $percent }}%; background:{{ $cat->color }}; opacity:0.4;"></div>
                </div>
                <span class="text-[10px] text-silver/25 w-4 text-right">{{ $cat->posts_count }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Signalements --}}
@if($reportedComments->count() > 0)
<div class="border p-6" style="border-color:#2a1515; background:#0a0808;">
    <div class="flex items-center gap-3 mb-6">
        <p class="text-[9px] tracking-[0.3em] uppercase text-red-500/40">Signalements</p>
        <span class="text-[10px] text-red-500/50 border border-red-900/30 px-2 py-0.5">
            {{ $reportedComments->count() }}
        </span>
    </div>
    <div class="space-y-4">
        @foreach($reportedComments as $commentId => $reports)
        @php $comment = $reports->first()->comment; @endphp
        @if($comment)
        <div class="border border-red-900/20 p-4">
            <div class="text-xs text-silver/50 mb-1 garamond italic">
                {{ $comment->user->name ?? '?' }}
                <span class="text-silver/25 not-italic font-inter text-[10px] ml-2">
                    sur "{{ Str::limit($comment->post->title ?? '', 30) }}"
                </span>
            </div>
            <p class="text-silver/35 text-sm garamond italic mb-3">
                "{{ Str::limit($comment->content, 100) }}"
            </p>
            <div class="text-[9px] text-silver/25 mb-3 font-inter">
                {{ $reports->count() }} signalement(s) : {{ $reports->pluck('reason')->unique()->implode(', ') }}
            </div>
            <div class="flex gap-4">
                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}">
                    @csrf @method('DELETE')
                    <button class="btn-admin text-[9px] border-red-900/30 text-red-500/40 hover:text-red-400/70 hover:border-red-800/50">
                        Supprimer
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.comments.dismiss-reports', $comment) }}">
                    @csrf
                    <button class="btn-admin text-[9px]">Ignorer</button>
                </form>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endif

@endsection