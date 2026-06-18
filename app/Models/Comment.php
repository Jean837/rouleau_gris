<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'post_id', 'user_id', 'parent_id', 'is_approved'];

    public function user() { return $this->belongsTo(User::class); }
    public function post() { return $this->belongsTo(Post::class); }
    public function parent() { return $this->belongsTo(Comment::class, 'parent_id'); }
    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->where('is_approved', true)
                    ->with('user')
                    ->orderBy('created_at', 'asc');
    }
    public function reports() { return $this->hasMany(Report::class); }
}