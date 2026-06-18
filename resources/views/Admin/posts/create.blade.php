@extends('admin.layout')
@section('content')

<h1 style="font-family:'Playfair Display',serif" class="text-2xl text-stone-200 mb-8">
    Nouveau fragment
</h1>

<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data"
      class="space-y-6 max-w-3xl">
    @csrf

    <div>
        <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Titre</label>
        <input type="text" name="title" value="{{ old('title') }}" required
               class="w-full bg-transparent border border-stone-800 text-stone-300 px-4 py-3 text-sm
                      focus:outline-none focus:border-stone-600 transition">
    </div>

    <div>
        <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Extrait</label>
        <textarea name="excerpt" rows="2"
                  class="w-full bg-transparent border border-stone-800 text-stone-300 px-4 py-3 text-sm
                         focus:outline-none focus:border-stone-600 transition resize-none">{{ old('excerpt') }}</textarea>
    </div>

    <div>
        <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Contenu</label>
        <textarea name="content" id="content" rows="16" required
                  class="w-full bg-transparent border border-stone-800 text-stone-300 px-4 py-3 text-sm
                         focus:outline-none focus:border-stone-600 transition resize-none font-mono">{{ old('content') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Catégorie</label>
            <select name="category_id" required
                    class="w-full bg-stone-900 border border-stone-800 text-stone-300 px-4 py-3 text-sm
                           focus:outline-none focus:border-stone-600 transition">
                <option value="">— Choisir —</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Statut</label>
            <select name="status"
                    class="w-full bg-stone-900 border border-stone-800 text-stone-300 px-4 py-3 text-sm
                           focus:outline-none focus:border-stone-600 transition">
                <option value="draft">Brouillon</option>
                <option value="published">Publié</option>
            </select>
        </div>
    </div>

    <div>
        <label class="block text-xs text-stone-600 tracking-widest uppercase mb-2">Image de couverture</label>
        <input type="file" name="cover_image" accept="image/*"
               class="w-full text-stone-600 text-sm border border-stone-800 px-4 py-3">
    </div>

    <div class="border border-stone-800 p-4 space-y-4">
        <div class="text-xs text-stone-600 tracking-widest uppercase">Vidéo (optionnel)</div>
        <div>
            <label class="block text-xs text-stone-700 mb-1">Lien YouTube / Vimeo</label>
            <input type="url" name="video_url" value="{{ old('video_url') }}"
                   class="w-full bg-transparent border border-stone-800 text-stone-400 px-4 py-2 text-sm
                          focus:outline-none focus:border-stone-600 transition"
                   placeholder="https://youtube.com/watch?v=...">
        </div>
        <div>
            <label class="block text-xs text-stone-700 mb-1">Upload vidéo (MP4)</label>
            <input type="file" name="video_file" accept="video/mp4,video/webm"
                   class="w-full text-stone-600 text-sm border border-stone-800 px-4 py-2">
        </div>
    </div>

    <button type="submit"
            class="border border-stone-700 text-stone-400 px-8 py-3 text-sm tracking-widest uppercase
                   hover:border-stone-500 hover:text-stone-200 transition">
        Publier le fragment
    </button>
</form>

@endsection