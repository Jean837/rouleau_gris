@extends('admin.layout')
@section('content')

<div class="mb-10">
    <p class="text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-1">Organisation</p>
    <h1 class="garamond italic text-4xl text-parchment/80">Catégories</h1>
</div>

<div class="grid grid-cols-2 gap-8 max-w-3xl">

    {{-- Créer --}}
    <div class="border p-6" style="border-color:#1c1c18; background:#0a0a08;">
        <p class="text-[9px] tracking-[0.3em] uppercase text-silver/25 mb-6">Nouvelle catégorie</p>
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-5">
            @csrf
            @error('name')
            <p class="text-[10px] text-red-400/60">{{ $message }}</p>
            @enderror
            <div>
                <label class="text-[9px] text-silver/30 block mb-1">Nom</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="input-admin" placeholder="Poésie, Journal...">
            </div>
            <div>
                <label class="text-[9px] text-silver/30 block mb-1">Couleur</label>
                <div class="flex items-center gap-3">
                    <input type="color" name="color" value="{{ old('color', '#6B7280') }}"
                           class="h-8 w-12 border border-white/8 bg-transparent cursor-pointer">
                    <span class="text-[10px] text-silver/25">Couleur d'accent</span>
                </div>
            </div>
            <button type="submit" class="btn-admin">Créer</button>
        </form>
    </div>

    {{-- Liste --}}
    <div class="border p-6" style="border-color:#1c1c18; background:#0a0a08;">
        <p class="text-[9px] tracking-[0.3em] uppercase text-silver/25 mb-6">Existantes</p>
        <div class="space-y-3">
            @forelse($categories as $cat)
            <div class="flex items-center justify-between py-2 border-b" style="border-color:#131410;">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full" style="background:{{ $cat->color }}; opacity:0.7;"></div>
                    <span class="garamond italic text-parchment/60 text-sm">{{ $cat->name }}</span>
                    <span class="text-[9px] text-silver/25">({{ $cat->posts_count }})</span>
                </div>
                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                      onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="text-[10px] text-silver/20 hover:text-red-400/50 transition">×</button>
                </form>
            </div>
            @empty
            <p class="garamond italic text-silver/20 text-sm">Aucune catégorie.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection