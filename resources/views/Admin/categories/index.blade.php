@extends('admin.layout')
@section('content')

<h1 style="font-family:'Playfair Display',serif" class="text-2xl text-stone-200 mb-8">Catégories</h1>

<div class="grid grid-cols-2 gap-8 max-w-3xl">
    <div class="border border-stone-800 p-6">
        <div class="text-xs text-stone-600 tracking-widest uppercase mb-5">Nouvelle catégorie</div>
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs text-stone-700 mb-1">Nom</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full bg-transparent border border-stone-800 text-stone-300 px-3 py-2 text-sm
                              focus:outline-none focus:border-stone-600 transition">
            </div>
            <div>
                <label class="block text-xs text-stone-700 mb-1">Couleur</label>
                <input type="color" name="color" value="{{ old('color', '#6B7280') }}"
                       class="h-8 w-16 bg-transparent border border-stone-800">
            </div>
            <button type="submit"
                    class="text-xs border border-stone-700 text-stone-400 px-4 py-2
                           hover:border-stone-500 hover:text-stone-200 transition">
                Créer
            </button>
        </form>
    </div>

    <div class="border border-stone-800 p-6">
        <div class="text-xs text-stone-600 tracking-widest uppercase mb-5">Existantes</div>
        <div class="space-y-3">
            @forelse($categories as $cat)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full" style="background:{{ $cat->color }}"></div>
                    <span class="text-stone-400 text-sm">{{ $cat->name }}</span>
                    <span class="text-stone-700 text-xs">({{ $cat->posts_count }})</span>
                </div>
                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                      onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-stone-700 hover:text-red-500 transition">×</button>
                </form>
            </div>
            @empty
            <p class="text-stone-700 text-sm italic">Aucune catégorie.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection