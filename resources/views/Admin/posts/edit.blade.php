@extends('admin.layout')
@section('content')

<div class="mb-10">
    <p class="text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-1">Modifier</p>
    <h1 class="garamond italic text-4xl text-parchment/80">Éditer le fragment</h1>
</div>

<form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data"
      class="space-y-8 max-w-3xl">
    @csrf @method('PUT')

    <div>
        <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Titre</label>
        <input type="text" name="title" value="{{ old('title', $post->title) }}" required
               class="input-admin garamond italic text-xl">
    </div>

    <div>
        <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Extrait</label>
        <textarea name="excerpt" rows="2" class="input-admin">{{ old('excerpt', $post->excerpt) }}</textarea>
    </div>

    <div>
        <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Contenu</label>
        <textarea name="content" rows="18" required class="input-admin font-mono text-sm">{{ old('content', $post->content) }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Catégorie</label>
            <select name="category_id" required class="input-admin" style="background:#0a0a08;">
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $post->category_id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">Statut</label>
            <select name="status" class="input-admin" style="background:#0a0a08;">
                <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Brouillon</option>
                <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Publié</option>
            </select>
        </div>
    </div>

    <div>
        <label class="text-[9px] tracking-[0.3em] uppercase text-silver/30 block mb-2">
            Nouvelle image de couverture
        </label>
        @if($post->cover_image)
        <img src="{{ Storage::url($post->cover_image) }}"
             class="h-20 mb-2 opacity-40 object-cover">
        @endif
        <input type="file" name="cover_image" accept="image/*"
               class="text-silver/40 text-xs w-full border border-white/8 px-4 py-3">
    </div>

    <div class="border p-5 space-y-4" style="border-color:#1c1c18;">
        <p class="text-[9px] tracking-[0.3em] uppercase text-silver/25">Vidéo</p>
        <div>
            <label class="text-[9px] text-silver/25 block mb-1">Lien YouTube / Vimeo</label>
            <input type="url" name="video_url" value="{{ old('video_url', $post->video_url) }}"
                   class="input-admin text-sm">
        </div>
        <div>
            <label class="text-[9px] text-silver/25 block mb-1">Fichier vidéo</label>
            @if($post->video_file)
            <p class="text-[10px] text-silver/25 mb-1">Actuel : {{ basename($post->video_file) }}</p>
            @endif
            <input type="file" name="video_file" accept="video/mp4,video/webm"
                   class="text-silver/40 text-xs w-full border border-white/8 px-4 py-3">
        </div>
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">
        Enregistrer les modifications
    </button>
</form>

@endsection