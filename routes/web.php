<?php
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

// ── Blog public ───────────────────────────────────────────
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/fragment/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/a-propos', fn() => view('blog.about'))->name('blog.about');

// ── Auth ──────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ── Vérification email ────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [EmailVerificationController::class, 'show'])->name('verify.email.form');
    Route::post('/verify-email', [EmailVerificationController::class, 'verify'])->name('verify.email');
    Route::post('/verify-email/resend', [EmailVerificationController::class, 'resend'])->name('verify.email.resend');
});

// ── Utilisateur connecté + vérifié ───────────────────────
Route::middleware(['auth', 'verified.custom'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('blog.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/fragment/{post}/comment', [BlogController::class, 'comment'])->name('blog.comment');
    Route::post('/fragment/{post}/like', [LikeController::class, 'toggle'])->name('post.like');
    Route::post('/fragment/{post}/rate', [RatingController::class, 'store'])->name('post.rate');

    Route::patch('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::post('/comment/{comment}/report', [CommentController::class, 'report'])->name('comment.report');
});

// ── Admin ─────────────────────────────────────────────────
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', AdminPostController::class);
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/dismiss-reports', [AdminCommentController::class, 'dismissReports'])->name('comments.dismiss-reports');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/promote', [UserController::class, 'promote'])->name('users.promote');
    Route::post('/users/{user}/demote', [UserController::class, 'demote'])->name('users.demote');
    Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
});