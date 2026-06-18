@extends('admin.layout')
@section('content')

<h1 style="font-family:'Playfair Display',serif" class="text-2xl text-stone-200 mb-8">Utilisateurs</h1>

<div class="border border-stone-800">
    <table class="w-full text-sm">
        <thead class="border-b border-stone-800">
            <tr class="text-xs text-stone-600 tracking-widest uppercase">
                <th class="px-4 py-3 text-left">Utilisateur</th>
                <th class="px-4 py-3 text-left">Rôle</th>
                <th class="px-4 py-3 text-left">Statut</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-900">
            @forelse($users as $user)
            <tr class="hover:bg-stone-900 transition {{ $user->is_banned ? 'opacity-50' : '' }}">
                <td class="px-4 py-3">
                    <div class="text-stone-300">{{ $user->name }}</div>
                    <div class="text-stone-700 text-xs">{{ $user->email }}</div>
                    @if($user->isNamedAdmin())
                    <div class="text-xs text-stone-500 italic">Administrateur nommé</div>
                    @endif
                    @if($user->is_banned)
                    <div class="text-xs text-red-700 italic">{{ Str::limit($user->ban_reason, 50) }}</div>
                    @endif
                </td>
                <td class="px-4 py-3 text-xs text-stone-600">
                    {{ $user->isNamedAdmin() ? 'Admin nommé' : 'Utilisateur' }}
                </td>
                <td class="px-4 py-3 text-xs">
                    <span class="{{ $user->is_banned ? 'text-red-700' : 'text-stone-600' }}">
                        {{ $user->is_banned ? 'Banni' : 'Actif' }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex flex-wrap gap-3 text-xs">
                        @if(!$user->is_banned)
                            @if($user->isNamedAdmin())
                            <form method="POST" action="{{ route('admin.users.demote', $user) }}">
                                @csrf
                                <button class="text-stone-600 hover:text-stone-300 transition">Rétrograder</button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('admin.users.promote', $user) }}">
                                @csrf
                                <button class="text-stone-600 hover:text-stone-300 transition">Nommer admin</button>
                            </form>
                            @endif
                            <button onclick="document.getElementById('ban-{{ $user->id }}').classList.toggle('hidden')"
                                    class="text-stone-700 hover:text-red-500 transition">
                                Bannir
                            </button>
                        @else
                        <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                            @csrf
                            <button class="text-stone-600 hover:text-stone-300 transition">Débannir</button>
                        </form>
                        @endif
                    </div>

                    @if(!$user->is_banned)
                    <div id="ban-{{ $user->id }}" class="hidden mt-3 border border-stone-800 p-3">
                        <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="space-y-2">
                            @csrf
                            <select name="ban_reason"
                                    class="w-full bg-stone-900 border border-stone-800 text-stone-400 px-2 py-1 text-xs focus:outline-none"
                                    onchange="document.getElementById('custom-{{ $user->id }}').classList[this.value === 'autre' ? 'remove' : 'add']('hidden')">
                                <option value="">— Raison —</option>
                                <option value="Spam ou publicité abusive">Spam</option>
                                <option value="Harcèlement ou menaces">Harcèlement</option>
                                <option value="Contenu haineux">Contenu haineux</option>
                                <option value="Violation des conditions d'utilisation">Violation CGU</option>
                                <option value="autre">Autre</option>
                            </select>
                            <div id="custom-{{ $user->id }}" class="hidden">
                                <input type="text" name="custom_ban_reason"
                                       class="w-full bg-stone-950 border border-stone-800 text-stone-400 px-2 py-1 text-xs focus:outline-none"
                                       placeholder="Précisez...">
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="text-xs text-red-700 hover:text-red-500 transition">
                                    Confirmer
                                </button>
                                <button type="button"
                                        onclick="document.getElementById('ban-{{ $user->id }}').classList.add('hidden')"
                                        class="text-xs text-stone-700 hover:text-stone-500 transition">
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
                <td colspan="4" class="px-4 py-10 text-center text-stone-700 text-sm italic">
                    Aucun utilisateur pour l'instant.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection