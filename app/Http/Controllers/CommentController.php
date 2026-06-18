<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function update(Request $request, Comment $comment) {
        if ($comment->user_id !== auth()->id()) abort(403);
        $request->validate(['content' => 'required|string|max:1000']);
        $comment->update(['content' => $request->content]);
        return back();
    }

    public function destroy(Comment $comment) {
        if ($comment->user_id !== auth()->id() && !auth()->user()->isAdmin()) abort(403);
        $comment->delete();
        return back();
    }

    public function report(Request $request, Comment $comment) {
        $request->validate([
            'reason'       => 'required|string',
            'other_reason' => 'nullable|string|max:500',
        ]);

        Report::updateOrCreate(
            ['comment_id' => $comment->id, 'user_id' => auth()->id()],
            ['reason' => $request->reason, 'other_reason' => $request->other_reason]
        );

        return back()->with('success', 'Commentaire signalé.');
    }
}