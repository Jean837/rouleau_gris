@extends('admin.layout')
@section('content')

<div class="flex justify-between items-center mb-8">
    <h1 style="font-family:'Playfair Display',serif" class="text-2xl text-stone-200">Fragments</h1>
    <a href="{{ route('admin.posts.create') }}"
       class="text-xs border border-stone-700 text-stone-400 px-4 py-2 hover:border-stone-500 hover:text-stone-200 transition">
        + Nouveau
    </a>
</div>

<div class="border border-stone-800">
    <table class="w-full text-sm">
        <thead class="border-b border-stone-800">
            <tr class="text-xs text-stone-600 tracking-widest uppercase">
                <th class="px-4 py-3 text-left">Titre</th>
                <th class="px-4 py-3 text-left">Catégorie</th>
                <th class="px-4 py-3 text-left">Statut</th>
                <th class="px-4 py-3 text-left">Vues</th>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-900">
            @forelse($posts as $post)
            <tr class="hover:bg-stone-900 transition">
                <td class="px-4 py-3 text-stone-300">{{ Str::limit($post->title, 40) }}</td>
                <td class="px-4 py-3 text-stone-600 text-xs">{{ $post->category->name ?? '—' }}</td>
                <td class="px-4 py-3">
                    <span class="text-xs {{ $post->status === 'published' ? 'text-stone-400' : 'text-stone-700' }}">
                        {{ $post->status === 'published' ? 'Publié' : 'Brouillon' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-stone-700 text-xs">{{ $post->views }}</td>
                <td class="px-4 py-3 text-stone-700 text-xs">{{ $post->created_at->format('d/m/Y') }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.posts.edit', $post) }}"
                           class="text-xs text-stone-600 hover:text-stone-300 transition">Éditer</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-stone-700 hover:text-red-500 transition">Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-10 text-center text-stone-700 text-sm italic">
                    Aucun fragment pour l'instant.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-stone-900">{{ $posts->links() }}</div>
</div>

@endsection