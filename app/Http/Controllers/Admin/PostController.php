<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('category', 'user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'video_file'  => 'nullable|mimes:mp4,webm,ogg|max:51200',
            'video_url'   => 'nullable|url',
            'status'      => 'required|in:draft,published',
        ]);

        $data = $request->only('title', 'content', 'excerpt', 'category_id', 'status', 'video_url');
        $data['user_id'] = Auth::id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }
        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('videos', 'public');
        }

        Post::create($data);
        return redirect()->route('admin.posts.index')->with('success', 'Article créé !');
    }

    public function edit(Post $post) {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post) {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'video_file'  => 'nullable|mimes:mp4,webm,ogg|max:51200',
            'video_url'   => 'nullable|url',
            'status'      => 'required|in:draft,published',
        ]);

        $data = $request->only('title', 'content', 'excerpt', 'category_id', 'status', 'video_url');

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) Storage::disk('public')->delete($post->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }
        if ($request->hasFile('video_file')) {
            if ($post->video_file) Storage::disk('public')->delete($post->video_file);
            $data['video_file'] = $request->file('video_file')->store('videos', 'public');
        }

        $post->update($data);
        return redirect()->route('admin.posts.index')->with('success', 'Article mis à jour !');
    }

    public function destroy(Post $post) {
        if ($post->cover_image) Storage::disk('public')->delete($post->cover_image);
        if ($post->video_file) Storage::disk('public')->delete($post->video_file);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Article supprimé.');
    }
}