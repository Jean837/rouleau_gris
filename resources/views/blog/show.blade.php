@extends('blog.layout')
@section('title', $post->title)
@section('description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('content')
<div class="max-w-3xl mx-auto px-6 py-20">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-3 mb-12 font-inter text-[10px] tracking-[0.2em] uppercase text-silver/30">
        <a href="{{ route('blog.index') }}" class="hover:text-silver/60 transition">Fragments</a>
        <span class="text-silver/15">›</span>
        <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
           class="hover:text-silver/60 transition">{{ $post->category->name }}</a>
        <span class="text-silver/15">›</span>
        <span class="text-silver/20">{{ Str::limit($post->title, 30) }}</span>
    </nav>

    {{-- En-tête --}}
    <header class="mb-14 fade-up">
        <span class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/30 block mb-5">
            {{ $post->category->name }}
        </span>
        <h1 class="font-garamond italic text-5xl md:text-6xl text-parchment/95 mb-8 leading-tight">
            {{ $post->title }}
        </h1>
        <div class="flex flex-wrap items-center gap-4 font-inter text-[10px] tracking-[0.2em] uppercase text-silver/30">
            <span>{{ $post->user->name }}</span>
            @if($post->user->isNamedAdmin())
            <span class="border border-silver/20 px-2 py-0.5 text-silver/30">Admin nommé</span>
            @endif
            <span class="text-silver/15">·</span>
            <span>{{ $post->created_at->format('d M Y') }}</span>
            <span class="text-silver/15">·</span>
            <span>{{ $post->reading_time }} min</span>
            <span class="text-silver/15">·</span>
            <span>{{ $post->views }} lecture(s)</span>
            <span class="text-silver/15">·</span>
            <div class="flex gap-0.5">
                @php $avg = $post->averageRating(); @endphp
                @for($i = 1; $i <= 5; $i++)
                <span class="{{ $i <= $avg ? 'text-parchment/50' : 'text-silver/15' }}">★</span>
                @endfor
                <span class="ml-1">({{ $post->ratings->count() }})</span>
            </div>
        </div>
        <div class="mt-8 w-full h-px bg-white/5"></div>
    </header>

    {{-- Image --}}
    @if($post->cover_image)
    <div class="mb-12 overflow-hidden">
        <img src="{{ Storage::url($post->cover_image) }}"
             class="w-full max-h-96 object-cover opacity-60 hover:opacity-80 transition duration-700"
             alt="{{ $post->title }}">
    </div>
    @endif

    {{-- Vidéo YouTube/Vimeo --}}
    @if($post->getVideoEmbedUrl())
    <div class="mb-12 aspect-video border border-white/8">
        <iframe src="{{ $post->getVideoEmbedUrl() }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
    </div>
    @endif

    {{-- Vidéo uploadée --}}
    @if($post->video_file)
    <div class="mb-12">
        <video controls class="w-full border border-white/8">
            <source src="{{ Storage::url($post->video_file) }}" type="video/mp4">
        </video>
    </div>
    @endif

    {{-- Contenu --}}
    <div class="prose-rouleau mb-16">
        {!! nl2br(e($post->content)) !!}
    </div>

    {{-- J'aime + Notation --}}
    <div class="border-t border-b border-white/5 py-8 mb-14 flex flex-col md:flex-row gap-8 items-start md:items-center justify-between">

        {{-- J'aime --}}
        <button id="like-btn" onclick="toggleLike({{ $post->id }})"
                class="flex items-center gap-3 font-inter text-xs tracking-[0.1em] uppercase transition-all duration-300
                       {{ $post->isLikedBy(auth()->id()) ? 'text-parchment/80' : 'text-silver/30 hover:text-silver/60' }}">
            <span id="like-icon" class="text-xl">{{ $post->isLikedBy(auth()->id()) ? '♥' : '♡' }}</span>
            <span id="like-count">{{ $post->likes->count() }}</span>
            <span>appréciation(s)</span>
        </button>

        {{-- Notation --}}
        @auth
        @if(auth()->user()->is_verified)
        <div class="flex items-center gap-4">
            <span class="font-inter text-[10px] tracking-[0.2em] uppercase text-silver/30">Note</span>
            <div class="flex gap-1">
                @php $userNote = $post->userRating(); @endphp
                @for($i = 1; $i <= 5; $i++)
                <span class="text-2xl cursor-pointer transition-all duration-200
                             {{ $userNote >= $i ? 'text-parchment/70' : 'text-silver/20 hover:text-silver/50' }}"
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
    <div class="mb-16">
        <p class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/25 mb-5">
            Partager ce fragment
        </p>
        <div class="flex flex-wrap gap-3">
            @php $url = urlencode(request()->url()); $title = urlencode($post->title); @endphp
            <a href="https://twitter.com/intent/tweet?text={{ $title }}&url={{ $url }}" target="_blank"
               class="flex items-center gap-2 font-inter text-[10px] tracking-[0.15em] uppercase
                      border border-white/8 text-silver/40 px-4 py-2.5
                      hover:border-white/20 hover:text-parchment/70 transition-all duration-400">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622 5.911-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
                X
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank"
               class="font-inter text-[10px] tracking-[0.15em] uppercase border border-white/8 text-silver/40
                      px-4 py-2.5 hover:border-white/20 hover:text-parchment/70 transition-all duration-400">
                Facebook
            </a>
            <a href="https://wa.me/?text={{ $title }}%20{{ $url }}" target="_blank"
               class="font-inter text-[10px] tracking-[0.15em] uppercase border border-white/8 text-silver/40
                      px-4 py-2.5 hover:border-white/20 hover:text-parchment/70 transition-all duration-400">
                WhatsApp
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}" target="_blank"
               class="font-inter text-[10px] tracking-[0.15em] uppercase border border-white/8 text-silver/40
                      px-4 py-2.5 hover:border-white/20 hover:text-parchment/70 transition-all duration-400">
                LinkedIn
            </a>
            <button onclick="copyLink(this)" data-url="{{ request()->url() }}"
                    class="font-inter text-[10px] tracking-[0.15em] uppercase border border-white/8 text-silver/40
                           px-4 py-2.5 hover:border-white/20 hover:text-parchment/70 transition-all duration-400">
                <span>Copier</span>
            </button>
        </div>
    </div>

    {{-- Fragments similaires --}}
    @if($related->isNotEmpty())
    <section class="mb-16">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-px h-6 bg-silver/20"></div>
            <p class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/30">
                Fragments similaires
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($related as $r)
            <a href="{{ route('blog.show', $r->slug) }}"
               class="group border border-white/6 p-5 hover:border-white/15 transition-all duration-500"
               style="background:#131410;">
                <span class="font-inter text-[9px] tracking-[0.2em] uppercase text-silver/30 block mb-2">
                    {{ $r->category->name }}
                </span>
                <h3 class="font-garamond italic text-lg text-parchment/70 group-hover:text-white transition leading-snug">
                    {{ Str::limit($r->title, 50) }}
                </h3>
                <span class="font-inter text-[9px] text-silver/25 mt-2 block">
                    {{ $r->created_at->format('d/m/Y') }}
                </span>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- COMMENTAIRES --}}
    <section id="comments" class="border-t border-white/5 pt-14">

        <div class="flex items-center gap-4 mb-10">
            <div class="w-px h-6 bg-silver/20"></div>
            <p class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/30">
                {{ $post->comments->count() }} réflexion(s)
            </p>
        </div>

        {{-- Liste commentaires --}}
        @forelse($post->comments as $comment)
        <div class="mb-10 group" id="comment-{{ $comment->id }}">
            <div class="flex gap-5">

                {{-- Avatar --}}
                <div class="w-8 h-8 border border-white/10 flex items-center justify-center
                            text-silver/50 text-xs font-inter flex-shrink-0 font-medium">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>

                <div class="flex-1">
                    {{-- Auteur + date --}}
                    <div class="flex items-center gap-3 mb-3">
                        <span class="font-inter text-xs text-parchment/60">{{ $comment->user->name }}</span>
                        @if($comment->user->isNamedAdmin())
                        <span class="font-inter text-[9px] border border-silver/20 text-silver/40 px-1.5 py-0.5">
                            Admin nommé
                        </span>
                        @endif
                        <span class="font-inter text-[10px] text-silver/25">
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>

                    {{-- Contenu --}}
                    <div id="comment-content-{{ $comment->id }}">
                        <p class="font-garamond text-lg text-silver/55 leading-relaxed">
                            {{ $comment->content }}
                        </p>
                    </div>

                    {{-- Formulaire édition --}}
                    @auth
                    @if(auth()->id() === $comment->user_id)
                    <div id="edit-form-{{ $comment->id }}" class="hidden mt-3">
                        <form method="POST" action="{{ route('comment.update', $comment) }}">
                            @csrf @method('PATCH')
                            <textarea name="content" rows="3"
                                      class="w-full bg-transparent border border-white/10 text-silver/60
                                             font-garamond text-base px-4 py-3 focus:outline-none
                                             focus:border-white/20 resize-none transition">{{ $comment->content }}</textarea>
                            <div class="flex gap-4 mt-2">
                                <button type="submit"
                                        class="font-inter text-[10px] tracking-[0.2em] uppercase text-silver/50
                                               border-b border-silver/20 hover:text-parchment/80 hover:border-parchment/50 transition pb-0.5">
                                    Enregistrer
                                </button>
                                <button type="button" onclick="toggleEdit('edit-form-{{ $comment->id }}')"
                                        class="font-inter text-[10px] tracking-[0.2em] uppercase text-silver/25
                                               hover:text-silver/50 transition">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                    @endauth

                    {{-- Actions --}}
                    <div class="flex items-center gap-5 mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        @auth
                        @if(auth()->user()->is_verified)
                        <button onclick="toggleReply('reply-form-{{ $comment->id }}')"
                                class="font-inter text-[9px] tracking-[0.2em] uppercase text-silver/30
                                       hover:text-silver/60 transition">
                            Répondre
                        </button>
                        @endif

                        @if(auth()->id() === $comment->user_id)
                        <button onclick="toggleEdit('edit-form-{{ $comment->id }}')"
                                class="font-inter text-[9px] tracking-[0.2em] uppercase text-silver/30
                                       hover:text-silver/60 transition">
                            Modifier
                        </button>
                        <form method="POST" action="{{ route('comment.destroy', $comment) }}"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="font-inter text-[9px] tracking-[0.2em] uppercase text-silver/25
                                           hover:text-red-400/60 transition">
                                Supprimer
                            </button>
                        </form>
                        @elseif(auth()->id() !== $comment->user_id)
                        <button onclick="toggleReport('report-{{ $comment->id }}')"
                                class="font-inter text-[9px] tracking-[0.2em] uppercase text-silver/20
                                       hover:text-silver/50 transition">
                            Signaler
                        </button>
                        @endif
                        @endauth
                    </div>

                    {{-- Signalement --}}
                    @auth
                    @if(auth()->id() !== $comment->user_id)
                    <div id="report-{{ $comment->id }}"
                         class="hidden mt-4 border border-white/8 p-5" style="background:#131410;">
                        <p class="font-inter text-[10px] tracking-[0.2em] uppercase text-silver/30 mb-4">
                            Raison du signalement
                        </p>
                        <form method="POST" action="{{ route('comment.report', $comment) }}">
                            @csrf
                            <div class="space-y-2.5 mb-4">
                                @foreach(['spam' => 'Spam ou publicité', 'harcelement' => 'Harcèlement', 'haineux' => 'Contenu haineux', 'faux' => 'Informations fausses', 'autre' => 'Autre raison'] as $val => $label)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="reason" value="{{ $val }}"
                                           class="accent-parchment"
                                           onchange="toggleOtherReason('other-{{ $comment->id }}', '{{ $val }}')">
                                    <span class="font-garamond italic text-sm text-silver/50">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                            <div id="other-{{ $comment->id }}" class="hidden mb-4">
                                <textarea name="other_reason" rows="2" placeholder="Précisez..."
                                          class="w-full bg-transparent border border-white/8 text-silver/50
                                                 font-garamond text-sm px-3 py-2 focus:outline-none
                                                 focus:border-white/20 resize-none transition"></textarea>
                            </div>
                            <div class="flex gap-4">
                                <button type="submit"
                                        class="font-inter text-[10px] tracking-[0.2em] uppercase
                                               text-silver/50 border-b border-silver/20 hover:text-parchment/70
                                               hover:border-parchment/40 transition pb-0.5">
                                    Envoyer
                                </button>
                                <button type="button" onclick="toggleReport('report-{{ $comment->id }}')"
                                        class="font-inter text-[10px] tracking-[0.2em] uppercase
                                               text-silver/25 hover:text-silver/50 transition">
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
                    <div id="reply-form-{{ $comment->id }}" class="hidden mt-4 ml-4 border-l border-white/8 pl-4">
                        <form method="POST" action="{{ route('blog.comment', $post) }}">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" rows="2" required placeholder="Votre réponse..."
                                      class="w-full bg-transparent border-b border-white/10 text-silver/60
                                             font-garamond text-base px-0 py-2 focus:outline-none
                                             focus:border-white/25 resize-none transition placeholder-white/15"></textarea>
                            <div class="flex gap-4 mt-2">
                                <button type="submit"
                                        class="font-inter text-[10px] tracking-[0.2em] uppercase text-silver/50
                                               border-b border-silver/20 hover:text-parchment/80 transition pb-0.5">
                                    Répondre
                                </button>
                                <button type="button" onclick="toggleReply('reply-form-{{ $comment->id }}')"
                                        class="font-inter text-[10px] tracking-[0.2em] uppercase text-silver/25
                                               hover:text-silver/50 transition">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                    @endauth

                    {{-- Réponses --}}
                    @if($comment->replies->isNotEmpty())
                    <div class="mt-6 ml-4 border-l border-white/5 pl-4 space-y-6">
                        @foreach($comment->replies as $reply)
                        <div class="flex gap-4 group/reply" id="comment-{{ $reply->id }}">
                            <div class="w-6 h-6 border border-white/8 flex items-center justify-center
                                        text-silver/40 text-[10px] flex-shrink-0">
                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="font-inter text-[10px] text-parchment/50">{{ $reply->user->name }}</span>
                                    @if($reply->user->isNamedAdmin())
                                    <span class="font-inter text-[9px] border border-silver/15 text-silver/30 px-1">Admin</span>
                                    @endif
                                    <span class="font-inter text-[9px] text-silver/20">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="font-garamond text-base text-silver/45 leading-relaxed">
                                    {{ $reply->content }}
                                </p>
                                @auth
                                @if(auth()->id() === $reply->user_id)
                                <form method="POST" action="{{ route('comment.destroy', $reply) }}"
                                      onsubmit="return confirm('Supprimer ?')"
                                      class="mt-1 opacity-0 group-hover/reply:opacity-100 transition">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="font-inter text-[9px] uppercase text-silver/20
                                                   hover:text-red-400/50 transition tracking-widest">
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
        <p class="font-garamond italic text-2xl text-silver/20 mb-10">
            Aucune réflexion pour l'instant. Soyez le premier à écrire.
        </p>
        @endforelse

        {{-- Formulaire principal --}}
        <div class="border-t border-white/5 pt-10 mt-8">
            @auth
                @if(auth()->user()->is_verified)
                <p class="font-inter text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-6">
                    Laisser une réflexion
                </p>
                <form method="POST" action="{{ route('blog.comment', $post) }}">
                    @csrf
                    <div class="flex gap-5">
                        <div class="w-8 h-8 border border-white/10 flex items-center justify-center
                                    text-silver/50 text-xs font-inter flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <textarea name="content" rows="4" required
                                      placeholder="Votre pensée sur ce fragment..."
                                      class="w-full bg-transparent border-b border-white/10 text-parchment/70
                                             font-garamond text-lg px-0 py-3 focus:outline-none
                                             focus:border-white/25 resize-none transition-all duration-400
                                             placeholder-white/10"></textarea>
                            @error('content')
                            <p class="text-red-400/60 text-xs mt-1 font-inter">{{ $message }}</p>
                            @enderror
                            <button type="submit"
                                    class="mt-4 font-inter text-[10px] tracking-[0.2em] uppercase
                                           border border-white/15 text-silver/50 px-6 py-2.5
                                           hover:border-white/30 hover:text-parchment/80 transition-all duration-400">
                                Publier
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <p class="font-garamond italic text-lg text-silver/40">
                    <a href="{{ route('verify.email.form') }}"
                       class="text-parchment/60 hover:text-parchment/90 transition underline underline-offset-4">
                        Vérifiez votre email
                    </a>
                    pour laisser une réflexion.
                </p>
                @endif
            @else
            <div class="text-center py-8">
                <p class="font-garamond italic text-2xl text-silver/40 mb-6">
                    Rejoignez l'archive pour participer
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('login') }}"
                       class="font-inter text-[10px] tracking-[0.2em] uppercase border border-white/15
                              text-silver/50 px-5 py-2.5 hover:border-white/30 hover:text-parchment/80 transition-all duration-400">
                        Entrer
                    </a>
                    <a href="{{ route('register') }}"
                       class="font-inter text-[10px] tracking-[0.2em] uppercase bg-parchment
                              text-surface px-5 py-2.5 hover:opacity-85 transition-all duration-400">
                        Rejoindre
                    </a>
                </div>
            </div>
            @endauth
        </div>

    </section>
</div>

<script>
function toggleReply(id) { document.getElementById(id).classList.toggle('hidden'); }
function toggleEdit(id) { document.getElementById(id).classList.toggle('hidden'); }
function toggleReport(id) { document.getElementById(id).classList.toggle('hidden'); }
function toggleOtherReason(id, val) {
    document.getElementById(id).classList[val === 'autre' ? 'remove' : 'add']('hidden');
}
function copyLink(btn) {
    navigator.clipboard.writeText(btn.dataset.url).then(() => {
        const span = btn.querySelector('span');
        span.textContent = 'Copié !';
        setTimeout(() => span.textContent = 'Copier', 2000);
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
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        const btn = document.getElementById('like-btn');
        const icon = document.getElementById('like-icon');
        const count = document.getElementById('like-count');
        count.textContent = data.count;
        icon.textContent = data.liked ? '♥' : '♡';
        if (data.liked) {
            btn.classList.remove('text-silver/30');
            btn.classList.add('text-parchment/80');
        } else {
            btn.classList.add('text-silver/30');
            btn.classList.remove('text-parchment/80');
        }
    });
    @else
    window.location.href = '{{ route("login") }}';
    @endauth
}
</script>

@endsection