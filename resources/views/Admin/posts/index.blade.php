@extends('admin.layout')
@section('content')

<div class="flex justify-between items-end mb-10">
    <div>
        <p class="text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-1">Contenu</p>
        <h1 class="garamond italic text-4xl text-parchment/80">Fragments</h1>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="btn-admin">+ Nouveau fragment</a>
</div>

<div class="border" style="border-color:#1c1c18;">
    <table class="w-full">
        <thead style="background:#0a0a08; border-bottom:1px solid #1c1c18;">
            <tr class="text-[9px] tracking-[0.3em] uppercase text-silver/25">
                <th class="px-5 py-3 text-left">Titre</th>
                <th class="px-5 py-3 text-left">Catégorie</th>
                <th class="px-5 py-3 text-left">Statut</th>
                <th class="px-5 py-3 text-left">Vues</th>
                <th class="px-5 py-3 text-left">Date</th>
                <th class="px-5 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr class="border-b transition-colors hover:bg-white/2"
                style="border-color:#131410;">
                <td class="px-5 py-4 garamond italic text-parchment/60 text-sm">
                    {{ Str::limit($post->title, 45) }}
                </td>
                <td class="px-5 py-4 text-[10px] text-silver/35 tracking-widest uppercase">
                    {{ $post->category->name ?? '—' }}
                </td>
                <td class="px-5 py-4">
                    <span class="text-[9px] tracking-[0.2em] uppercase
                                 {{ $post->status === 'published' ? 'text-parchment/50' : 'text-silver/25' }}">
                        {{ $post->status === 'published' ? 'Publié' : 'Brouillon' }}
                    </span>
                </td>
                <td class="px-5 py-4 text-[10px] text-silver/25">{{ $post->views }}</td>
                <td class="px-5 py-4 text-[10px] text-silver/25">{{ $post->created_at->format('d/m/Y') }}</td>
                <td class="px-5 py-4">
                    <div class="flex gap-4">
                        <a href="{{ route('admin.posts.edit', $post) }}"
                           class="text-[9px] tracking-widest uppercase text-silver/35 hover:text-silver/60 transition">
                            Éditer
                        </a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                              onsubmit="return confirm('Supprimer ce fragment ?')">
                            @csrf @method('DELETE')
                            <button class="text-[9px] tracking-widest uppercase text-silver/20
                                          hover:text-red-400/50 transition">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-12 text-center garamond italic text-silver/20">
                    Aucun fragment pour l'instant.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-3 border-t text-silver/25" style="border-color:#131410;">
        {{ $posts->links() }}
    </div>
</div>

@endsection