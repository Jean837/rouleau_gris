<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function destroy(Comment $comment) {
        $comment->delete();
        return back()->with('success', 'Commentaire supprimé.');
    }

    public function dismissReports(Comment $comment) {
        $comment->reports()->delete();
        return back()->with('success', 'Signalements ignorés.');
    }
}