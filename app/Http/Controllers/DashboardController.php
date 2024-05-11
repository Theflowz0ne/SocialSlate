<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $posts = Post::with(['user:id,first_name,last_name', 'likes', 'reshares'])
            ->whereDoesntHave('hiddenByUsers', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($post) use ($userId) {
                $post->formatted_date = $post->created_at->format('M d, Y');
                $post->canEdit = auth()->user()->can('update', $post);
                $post->canDelete = auth()->user()->can('delete', $post);
                $post->liked_by_user = $post->likes->contains('user_id', $userId);
                $post->reshared_by_user = $post->reshares->contains('user_id', $userId);
                return $post;
            });

        return Inertia::render('Dashboard', ['posts' => $posts]);
    }
}
