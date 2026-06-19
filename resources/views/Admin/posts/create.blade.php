@extends('admin.layout')
@section('content')

<div class="mb-10">
    <p class="text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-1">Créer</p>
    <h1 class="garamond italic text-4xl text-parchment/80">Nouveau fragment</h1>
</div>

<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data"
      class="space-y-8 max-w-3xl">
    @csrf

    <div>
        <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Titre</label>
        <input type="text" name="title" value="{{ old('title') }}" required
               class="input-admin garamond italic text-xl" placeholder="Le titre du fragment...">
    </div>

    <div>
        <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Extrait</label>
        <textarea name="excerpt" rows="2" class="input-admin"
                  placeholder="Un court résumé...">{{ old('excerpt') }}</textarea>
    </div>

    <div>
        <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Contenu</label>
        <textarea name="content" rows="18" required class="input-admin font-mono text-sm"
                  placeholder="Le corps du fragment...">{{ old('content') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Catégorie</label>
            <select name="category_id" required class="input-admin"
                    style="background:#0a0a08;">
                <option value="">— Choisir —</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Statut</label>
            <select name="status" class="input-admin" style="background:#0a0a08;">
                <option value="draft">Brouillon</option>
                <option value="published">Publié</option>
            </select>
        </div>
    </div>

    <div>
        <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Image de couverture</label>
        <input type="file" name="cover_image" accept="image/*"
               class="text-silver/40 text-xs w-full border border-white/8 px-4 py-3">
    </div>

    <div class="border p-5 space-y-4" style="border-color:#1c1c18;">
        <p class="text-[9px] tracking-[0.3em] uppercase text-silver/25">Vidéo (optionnel)</p>
        <div>
            <label class="text-[9px] text-silver/25 block mb-1">Lien YouTube / Vimeo</label>
            <input type="url" name="video_url" value="{{ old('video_url') }}"
                   class="input-admin text-sm" placeholder="https://youtube.com/...">
        </div>
        <div>
            <label class="text-[9px] text-silver/25 block mb-1">Fichier vidéo (MP4)</label>
            <input type="file" name="video_file" accept="video/mp4,video/webm"
                   class="text-silver/40 text-xs w-full border border-white/8 px-4 py-3">
        </div>
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">
        Publier le fragment
    </button>
</form>

@endsection