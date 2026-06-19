@extends('admin.layout')
@section('content')

<div class="mb-10">
    <p class="text-[10px] tracking-[0.3em] uppercase text-silver/30 mb-1">Communauté</p>
    <h1 class="garamond italic text-4xl text-parchment/80">Initiés</h1>
</div>

<div class="border" style="border-color:#1c1c18;">
    <table class="w-full">
        <thead style="background:#0a0a08; border-bottom:1px solid #1c1c18;">
            <tr class="text-[9px] tracking-[0.3em] uppercase text-silver/25">
                <th class="px-5 py-3 text-left">Initié</th>
                <th class="px-5 py-3 text-left">Rôle</th>
                <th class="px-5 py-3 text-left">Statut</th>
                <th class="px-5 py-3 text-left">Membre depuis</th>
                <th class="px-5 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-b hover:bg-white/1 transition {{ $user->is_banned ? 'opacity-40' : '' }}"
                style="border-color:#131410;">

                <td class="px-5 py-4">
                    <div class="garamond italic text-parchment/60 text-sm">{{ $user->name }}</div>
                    <div class="text-[10px] text-silver/25">{{ $user->email }}</div>
                    @if($user->isNamedAdmin())
                    <div class="text-[9px] text-silver/35 italic">Administrateur nommé</div>
                    @endif
                    @if($user->is_banned)
                    <div class="text-[9px] text-red-400/40 italic mt-0.5">
                        {{ Str::limit($user->ban_reason, 40) }}
                    </div>
                    @endif
                </td>

                <td class="px-5 py-4 text-[10px] text-silver/35 tracking-widest uppercase">
                    {{ $user->isNamedAdmin() ? 'Admin nommé' : 'Initié' }}
                </td>

                <td class="px-5 py-4">
                    <span class="text-[9px] tracking-widest uppercase
                                 {{ $user->is_banned ? 'text-red-400/40' : 'text-parchment/40' }}">
                        {{ $user->is_banned ? 'Banni' : 'Actif' }}
                    </span>
                </td>

                <td class="px-5 py-4 text-[10px] text-silver/25">
                    {{ $user->created_at->format('d/m/Y') }}
                </td>

                <td class="px-5 py-4">
                    <div class="flex flex-wrap gap-3 text-[9px] tracking-widest uppercase mb-2">
                        @if(!$user->is_banned)
                            @if($user->isNamedAdmin())
                            <form method="POST" action="{{ route('admin.users.demote', $user) }}">
                                @csrf
                                <button class="text-silver/35 hover:text-silver/60 transition">Rétrograder</button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('admin.users.promote', $user) }}">
                                @csrf
                                <button class="text-silver/35 hover:text-silver/60 transition">Nommer admin</button>
                            </form>
                            @endif
                            <button onclick="document.getElementById('ban-{{ $user->id }}').classList.toggle('hidden')"
                                    class="text-silver/20 hover:text-red-400/50 transition">
                                Bannir
                            </button>
                        @else
                        <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                            @csrf
                            <button class="text-silver/35 hover:text-silver/60 transition">Débannir</button>
                        </form>
                        @endif
                    </div>

                    {{-- Formulaire bannissement --}}
                    @if(!$user->is_banned)
                    <div id="ban-{{ $user->id }}" class="hidden mt-2 border p-3 max-w-xs"
                         style="border-color:#2a1515; background:#0a0808;">
                        <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="space-y-2">
                            @csrf
                            <select name="ban_reason"
                                    class="w-full bg-transparent border border-white/8 text-silver/40
                                           text-[10px] px-2 py-1.5 focus:outline-none"
                                    onchange="document.getElementById('custom-ban-{{ $user->id }}').classList[this.value==='autre'?'remove':'add']('hidden')">
                                <option value="">— Raison —</option>
                                <option value="Spam ou publicité abusive">Spam</option>
                                <option value="Harcèlement ou menaces">Harcèlement</option>
                                <option value="Contenu haineux">Contenu haineux</option>
                                <option value="Violation des conditions">Violation CGU</option>
                                <option value="autre">Autre</option>
                            </select>
                            <div id="custom-ban-{{ $user->id }}" class="hidden">
                                <input type="text" name="custom_ban_reason"
                                       class="w-full bg-transparent border border-white/8 text-silver/40
                                              text-[10px] px-2 py-1.5 focus:outline-none"
                                       placeholder="Précisez...">
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                        class="text-[9px] tracking-widest uppercase text-red-400/40
                                               hover:text-red-400/70 transition border-b border-red-900/30 pb-0.5">
                                    Confirmer
                                </button>
                                <button type="button"
                                        onclick="document.getElementById('ban-{{ $user->id }}').classList.add('hidden')"
                                        class="text-[9px] tracking-widest uppercase text-silver/20
                                               hover:text-silver/40 transition">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-12 text-center garamond italic text-silver/20">
                    Aucun initié pour l'instant.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection