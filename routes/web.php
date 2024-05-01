<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $posts = Post::query()
        ->select('posts.content', 'posts.created_at', 'posts.id')
        ->addSelect(['author_name' => function ($query) {
            $query->select('name')
                ->from('users')
                ->whereColumn('users.id', 'posts.user_id');
        }])
        ->with('user:id,name')
        ->orderBy('posts.created_at', 'desc')
        ->get()->map(function ($post) {
            $post->formatted_date = $post->created_at->format('M d, Y');
            $post->canEdit = auth()->user()->can('update', $post);
            $post->canDelete = auth()->user()->can('delete', $post);
            return $post;
        });

    return Inertia::render('Dashboard', ['posts' => $posts]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('posts', PostController::class);

    Route::post('/posts/{post}/edit', [PostController::class, 'update'])->name('posts.update');
    Route::post('/posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.delete');
});

require __DIR__ . '/auth.php';
