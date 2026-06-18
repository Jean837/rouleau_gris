<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request) {
        $query = Post::with('category', 'user')
                     ->where('status', 'published')
                     ->orderBy('created_at', 'desc');

        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('content', 'like', '%'.$request->search.'%');
            });
        }

        $posts      = $query->paginate(6);
        $categories = Category::withCount('posts')->get();
        $featured   = Post::with('category', 'user')
                          ->where('status', 'published')
                          ->orderBy('views', 'desc')
                          ->first();

        return view('blog.index', compact('posts', 'categories', 'featured'));
    }

    public function show(string $slug) {
        $post = Post::with([
                        'category', 'user', 'ratings', 'likes',
                        'comments' => function($q) {
                            $q->whereNull('parent_id')
                              ->where('is_approved', true)
                              ->with(['user', 'replies.user', 'reports'])
                              ->orderBy('created_at', 'desc');
                        }
                    ])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        $sessionKey = 'viewed_post_' . $post->id;
        if (!session()->has($sessionKey)) {
            $post->increment('views');
            session()->put($sessionKey, true);
        }

        $related = Post::where('category_id', $post->category_id)
                       ->where('id', '!=', $post->id)
                       ->where('status', 'published')
                       ->limit(3)->get();

        return view('blog.show', compact('post', 'related'));
    }

    public function comment(Request $request, Post $post) {
        $request->validate([
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'content'     => $request->content,
            'post_id'     => $post->id,
            'user_id'     => Auth::id(),
            'parent_id'   => $request->parent_id ?? null,
            'is_approved' => true,
        ]);

        return back();
    }
}