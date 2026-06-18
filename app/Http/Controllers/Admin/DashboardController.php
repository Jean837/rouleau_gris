<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        $stats = [
            'total_posts'      => Post::count(),
            'published_posts'  => Post::where('status', 'published')->count(),
            'draft_posts'      => Post::where('status', 'draft')->count(),
            'total_views'      => Post::sum('views'),
            'total_comments'   => Comment::count(),
            'total_users'      => User::count(),
            'total_categories' => Category::count(),
            'total_reports'    => Report::count(),
        ];

        $topPosts         = Post::where('status', 'published')->orderBy('views', 'desc')->limit(5)->get();
        $postsByCategory  = Category::withCount('posts')->get();
        $reportedComments = Report::with('comment.user', 'comment.post', 'user')
                                  ->latest()->get()->groupBy('comment_id');

        return view('admin.dashboard', compact('stats', 'topPosts', 'postsByCategory', 'reportedComments'));
    }
}