@extends('blog.layout')
@section('title', $post->title)
@section('description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('content')
<div class="max-w-3xl mx-auto px-6 py-16">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-stone-600 mb-10 flex items-center gap-2">
        <a href="{{ route('blog.index') }}" class="hover:text-stone-400 transition">Fragments</a>
        <span>›</span>
        <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
           class="hover:text-stone-400 transition">{{ $post->category->name }}</a>
    </nav>

    {{-- En-tête --}}
    <header class="mb-12">
        <span class="text-xs tracking-widest uppercase text-stone-600 mb-4 block">
            {{ $post->category->name }}
        </span>
        <h1 class="font-serif text-4xl md:text-5xl text-stone-100 mb-6 leading-tight">
            {{ $post->title }}
        </h1>
        <div class="flex flex-wrap items-center gap-4 text-xs text-stone-600">
            <span>{{ $post->user->name }}</span>
            @if($post->user->isNamedAdmin())
            <span class="border border-stone-700 px-2 py-0.5 text-stone-500">Admin nommé</span>
            @endif
            <span>·</span>
            <span>{{ $post->created_at->format('d M Y') }}</span>
            <span>·</span>
            <span>{{ $post->reading_time }} min de lecture</span>
            <span>·</span>
            <span>{{ $post->views }} lecture(s)</span>
            <span>·</span>
            <div class="flex gap-0.5">
                @php $avg = $post->averageRating(); @endphp
                @for($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= $avg ? 'text-stone-400' : 'text-stone-700' }}">★</span>
                @endfor
                <span class="ml-1">({{ $post->ratings->count() }})</span>
            </div>
        </div>
        <div class="mt-6 w-full h-px bg-stone-800"></div>
    </header>

    {{-- Image --}}
    @if($post->cover_image)
    <div class="mb-10 overflow-hidden">
        <img src="{{ Storage::url($post->cover_image) }}"
             class="w-full max-h-80 object-cover opacity-70" alt="{{ $post->title }}">
    </div>
    @endif

    {{-- Vidéo --}}
    @if($post->getVideoEmbedUrl())
    <div class="mb-10 aspect-video">
        <iframe src="{{ $post->getVideoEmbedUrl() }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
    </div>
    @endif

    @if($post->video_file)
    <div class="mb-10">
        <video controls class="w-full">
            <source src="{{ Storage::url($post->video_file) }}" type="video/mp4">
        </video>
    </div>
    @endif

    {{-- Contenu --}}
    <div class="prose-rouleau text-stone-300 leading-loose mb-12">
        {!! nl2br(e($post->content)) !!}
    </div>

    {{-- J'aime + Notation --}}
    <div class="border-t border-b border-stone-800 py-6 mb-12 flex flex-col md:flex-row gap-6 items-start md:items-center justify-between">

        {{-- J'aime --}}
        <div class="flex items-center gap-4">
            <button id="like-btn" onclick="toggleLike({{ $post->id }})"
                    class="flex items-center gap-2 text-sm transition
                           {{ $post->isLikedBy(auth()->id()) ? 'text-stone-200' : 'text-stone-600 hover:text-stone-400' }}">
                <span id="like-icon" class="text-lg">{{ $post->isLikedBy(auth()->id()) ? '♥' : '♡' }}</span>
                <span id="like-count">{{ $post->likes->count() }}</span>
                <span>{{ $post->likes->count() > 1 ? 'appréciations' : 'appréciation' }}</span>
            </button>
        </div>

        {{-- Notation --}}
        @auth
        @if(auth()->user()->is_verified)
        <div class="flex items-center gap-3">
            <span class="text-xs text-stone-600 tracking-widest uppercase">Votre note</span>
            <div class="flex gap-1">
                @php $userNote = $post->userRating(); @endphp
                @for($i = 1; $i <= 5; $i++)
                <span class="text-xl cursor-pointer transition
                             {{ $userNote >= $i ? 'text-stone-300' : 'text-stone-700 hover:text-stone-500' }}"
                      onclick="submitRating({{ $i }}, {{ $post->id }})">★</span>
                @endfor
            </div>
            <form id="rating-form-{{ $post->id }}" method="POST" action="{{ route('post.rate', $post) }}">
                @csrf
                <input type="hidden" name="stars" id="stars-input-{{ $post->id }}">
            </form>
        </div>
        @endif
        @endauth
    </div>

    {{-- Partage --}}
    <div class="mb-12">
        <p class="text-xs text-stone-600 tracking-widest uppercase mb-4">Partager ce fragment</p>
        <div class="flex flex-wrap gap-3">
            @php $url = urlencode(request()->url()); $title = urlencode($post->title); @endphp
            <a href="https://twitter.com/intent/tweet?text={{ $title }}&url={{ $url }}" target="_blank"
               class="text-xs text-stone-500 border border-stone-800 px-3 py-2 hover:border-stone-600 hover:text-stone-300 transition flex items-center gap-2">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622 5.911-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
                X
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank"
               class="text-xs text-stone-500 border border-stone-800 px-3 py-2 hover:border-stone-600 hover:text-stone-300 transition">
                Facebook
            </a>
            <a href="https://wa.me/?text={{ $title }}%20{{ $url }}" target="_blank"
               class="text-xs text-stone-500 border border-stone-800 px-3 py-2 hover:border-stone-600 hover:text-stone-300 transition">
                WhatsApp
            </a>
            <button onclick="copyLink(this)" data-url="{{ request()->url() }}"
                    class="text-xs text-stone-500 border border-stone-800 px-3 py-2 hover:border-stone-600 hover:text-stone-300 transition">
                <span>Copier le lien</span>
            </button>
        </div>
    </div>

    {{-- Articles liés --}}
    @if($related->isNotEmpty())
    <section class="mb-12">
        <p class="text-xs text-stone-600 tracking-widest uppercase mb-6">Fragments similaires</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($related as $r)
            <a href="{{ route('blog.show', $r->slug) }}"
               class="border border-stone-800 p-4 hover:border-stone-700 hover:bg-stone-900 transition group">
                <span class="text-xs text-stone-600 block mb-2">{{ $r->category->name }}</span>
                <h3 class="font-serif text-stone-300 group-hover:text-white transition text-sm leading-snug">
                    {{ Str::limit($r->title, 50) }}
                </h3>
                <span class="text-xs text-stone-700 mt-2 block">{{ $r->created_at->format('d/m/Y') }}</span>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- COMMENTAIRES --}}
    <section id="comments" class="border-t border-stone-800 pt-12">

        <p class="text-xs text-stone-600 tracking-widest uppercase mb-8">
            {{ $post->comments->count() }} réflexion(s)
        </p>

        @forelse($post->comments as $comment)
        <div class="mb-8" id="comment-{{ $comment->id }}">
            <div class="flex gap-4">
                <div class="w-8 h-8 bg-stone-800 border border-stone-700 flex items-center justify-center
                            text-stone-400 text-xs font-medium flex-shrink-0">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-sm text-stone-300">{{ $comment->user->name }}</span>
                        @if($comment->user->isNamedAdmin())
                        <span class="text-xs border border-stone-700 text-stone-500 px-1.5 py-0.5">Admin nommé</span>
                        @endif
                        <span class="text-xs text-stone-700">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>

                    <div id="comment-content-{{ $comment->id }}">
                        <p class="text-stone-400 text-sm leading-relaxed">{{ $comment->content }}</p>
                    </div>

                    @auth
                    @if(auth()->id() === $comment->user_id)
                    <div id="edit-form-{{ $comment->id }}" class="hidden mt-2">
                        <form method="POST" action="{{ route('comment.update', $comment) }}">
                            @csrf @method('PATCH')
                            <textarea name="content" rows="2"
                                      class="w-full bg-stone-900 border border-stone-700 text-stone-300 px-3 py-2
                                             text-sm focus:outline-none focus:border-stone-500 resize-none rounded-none">{{ $comment->content }}</textarea>
                            <div class="flex gap-2 mt-2">
                                <button type="submit" class="text-xs text-stone-400 border border-stone-700 px-3 py-1 hover:border-stone-500 transition">
                                    Enregistrer
                                </button>
                                <button type="button" onclick="toggleEdit('edit-form-{{ $comment->id }}')"
                                        class="text-xs text-stone-600 hover:text-stone-400 transition">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                    @endauth

                    {{-- Actions --}}
                    <div class="flex items-center gap-4 mt-2">
                        @auth
                        @if(auth()->user()->is_verified)
                        <button onclick="toggleReply('reply-form-{{ $comment->id }}')"
                                class="text-xs text-stone-700 hover:text-stone-400 transition">
                            Répondre
                        </button>
                        @endif

                        @if(auth()->id() === $comment->user_id)
                        <button onclick="toggleEdit('edit-form-{{ $comment->id }}')"
                                class="text-xs text-stone-700 hover:text-stone-400 transition">
                            Modifier
                        </button>
                        <form method="POST" action="{{ route('comment.destroy', $comment) }}"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-stone-700 hover:text-red-500 transition">
                                Supprimer
                            </button>
                        </form>
                        @elseif(auth()->id() !== $comment->user_id)
                        <button onclick="toggleReport('report-{{ $comment->id }}')"
                                class="text-xs text-stone-700 hover:text-stone-400 transition">
                            Signaler
                        </button>
                        @endif
                        @endauth
                    </div>

                    {{-- Signalement --}}
                    @auth
                    @if(auth()->id() !== $comment->user_id)
                    <div id="report-{{ $comment->id }}" class="hidden mt-3 bg-stone-900 border border-stone-800 p-4">
                        <p class="text-xs text-stone-500 mb-3">Raison du signalement</p>
                        <form method="POST" action="{{ route('comment.report', $comment) }}">
                            @csrf
                            <div class="space-y-2 mb-3">
                                @foreach(['spam' => 'Spam', 'harcelement' => 'Harcèlement', 'haineux' => 'Contenu haineux', 'faux' => 'Informations fausses', 'autre' => 'Autre'] as $value => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="reason" value="{{ $value }}"
                                           class="accent-stone-500"
                                           onchange="toggleOtherReason('other-{{ $comment->id }}', '{{ $value }}')">
                                    <span class="text-xs text-stone-400">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                            <div id="other-{{ $comment->id }}" class="hidden mb-3">
                                <textarea name="other_reason" rows="2"
                                          class="w-full bg-stone-950 border border-stone-700 text-stone-400 px-3 py-2
                                                 text-xs focus:outline-none resize-none"
                                          placeholder="Précisez..."></textarea>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="text-xs text-stone-400 border border-stone-700 px-3 py-1 hover:border-stone-500 transition">
                                    Envoyer
                                </button>
                                <button type="button" onclick="toggleReport('report-{{ $comment->id }}')"
                                        class="text-xs text-stone-600 hover:text-stone-400 transition">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                    @endauth

                    {{-- Formulaire réponse --}}
                    @auth
                    @if(auth()->user()->is_verified)
                    <div id="reply-form-{{ $comment->id }}" class="hidden mt-3">
                        <form method="POST" action="{{ route('blog.comment', $post) }}">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" rows="2" required
                                      class="w-full bg-stone-900 border border-stone-700 text-stone-300 px-3 py-2
                                             text-sm focus:outline-none focus:border-stone-500 resize-none"
                                      placeholder="Votre réponse..."></textarea>
                            <div class="flex gap-2 mt-2">
                                <button type="submit" class="text-xs text-stone-400 border border-stone-700 px-3 py-1 hover:border-stone-500 transition">
                                    Répondre
                                </button>
                                <button type="button" onclick="toggleReply('reply-form-{{ $comment->id }}')"
                                        class="text-xs text-stone-600 hover:text-stone-400 transition">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                    @endauth

                    {{-- Réponses --}}
                    @if($comment->replies->isNotEmpty())
                    <div class="mt-4 ml-4 border-l border-stone-800 pl-4 space-y-4">
                        @foreach($comment->replies as $reply)
                        <div class="flex gap-3">
                            <div class="w-6 h-6 bg-stone-800 flex items-center justify-center text-stone-500 text-xs flex-shrink-0">
                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs text-stone-400">{{ $reply->user->name }}</span>
                                    <span class="text-xs text-stone-700">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-stone-500 text-xs leading-relaxed">{{ $reply->content }}</p>
                                @auth
                                @if(auth()->id() === $reply->user_id)
                                <form method="POST" action="{{ route('comment.destroy', $reply) }}"
                                      onsubmit="return confirm('Supprimer ?')" class="mt-1">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-stone-700 hover:text-red-500 transition">
                                        Supprimer
                                    </button>
                                </form>
                                @endif
                                @endauth
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @empty
        <p class="font-serif text-stone-600 italic text-sm mb-8">
            Aucune réflexion pour l'instant. Soyez le premier à écrire.
        </p>
        @endforelse

        {{-- Formulaire principal --}}
        <div class="mt-10 border-t border-stone-800 pt-8">
            @auth
                @if(auth()->user()->is_verified)
                <p class="text-xs text-stone-600 tracking-widest uppercase mb-4">Laisser une réflexion</p>
                <form method="POST" action="{{ route('blog.comment', $post) }}">
                    @csrf
                    <div class="flex gap-4">
                        <div class="w-8 h-8 bg-stone-800 border border-stone-700 flex items-center justify-center
                                    text-stone-400 text-xs font-medium flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <textarea name="content" rows="4" required
                                      class="w-full bg-stone-900 border border-stone-800 text-stone-300 px-4 py-3
                                             text-sm focus:outline-none focus:border-stone-600 resize-none transition"
                                      placeholder="Votre pensée sur ce fragment..."></textarea>
                            <button type="submit"
                                    class="mt-3 text-xs text-stone-400 border border-stone-700 px-4 py-2
                                           hover:border-stone-500 hover:text-stone-200 transition">
                                Publier
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <p class="text-sm text-stone-600">
                    <a href="{{ route('verify.email.form') }}" class="text-stone-400 hover:text-stone-200 transition underline">
                        Vérifiez votre email
                    </a> pour laisser une réflexion.
                </p>
                @endif
            @else
            <p class="text-sm text-stone-600">
                <a href="{{ route('login') }}" class="text-stone-400 hover:text-stone-200 transition underline">Entrez</a>
                ou
                <a href="{{ route('register') }}" class="text-stone-400 hover:text-stone-200 transition underline">rejoignez</a>
                pour laisser une réflexion.
            </p>
            @endauth
        </div>

    </section>
</div>

<script>
function toggleReply(id) { document.getElementById(id).classList.toggle('hidden'); }
function toggleEdit(id) { document.getElementById(id).classList.toggle('hidden'); }
function toggleReport(id) { document.getElementById(id).classList.toggle('hidden'); }
function toggleOtherReason(id, value) {
    document.getElementById(id).classList[value === 'autre' ? 'remove' : 'add']('hidden');
}
function copyLink(btn) {
    navigator.clipboard.writeText(btn.dataset.url).then(() => {
        btn.querySelector('span').textContent = 'Copié !';
        setTimeout(() => btn.querySelector('span').textContent = 'Copier le lien', 2000);
    });
}
function submitRating(stars, postId) {
    document.getElementById('stars-input-' + postId).value = stars;
    document.getElementById('rating-form-' + postId).submit();
}
function toggleLike(postId) {
    @auth
    fetch('/fragment/' + postId + '/like', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('like-count').textContent = data.count;
        document.getElementById('like-icon').textContent = data.liked ? '♥' : '♡';
        document.getElementById('like-btn').classList[data.liked ? 'remove' : 'add']('text-stone-600');
        document.getElementById('like-btn').classList[data.liked ? 'add' : 'remove']('text-stone-200');
    });
    @else
    window.location.href = '{{ route("login") }}';
    @endauth
}
</script>

@endsection