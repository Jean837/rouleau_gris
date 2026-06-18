<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::where('role', '!=', 'admin')->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function promote(User $user) {
        if ($user->role === 'user') {
            $user->update(['role' => 'named_admin']);
            return back()->with('success', $user->name . ' est maintenant administrateur nommé !');
        }
        return back()->with('error', 'Impossible de promouvoir.');
    }

    public function demote(User $user) {
        if ($user->role === 'named_admin') {
            $user->update(['role' => 'user']);
            return back()->with('success', $user->name . ' est redevenu utilisateur.');
        }
        return back()->with('error', 'Impossible de rétrograder.');
    }

    public function ban(Request $request, User $user) {
        $reason = $request->ban_reason === 'autre' ? $request->custom_ban_reason : $request->ban_reason;
        if (empty($reason)) return back()->with('error', 'Choisissez une raison.');
        $user->update(['is_banned' => true, 'ban_reason' => $reason]);
        return back()->with('success', $user->name . ' a été banni.');
    }

    public function unban(User $user) {
        $user->update(['is_banned' => false, 'ban_reason' => null]);
        return back()->with('success', $user->name . ' a été débanni.');
    }
}