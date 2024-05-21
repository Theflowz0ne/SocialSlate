<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Get the IDs of users who have blocked the authenticated user or are blocked by the authenticated user
        $blockedUserIds = User::where('id', $userId)->with(['blockedUsers', 'blockingUsers'])->get()
            ->flatMap(function ($user) {
                return $user->blockedUsers->pluck('id')->merge($user->blockingUsers->pluck('id'));
            })
            ->unique()
            ->toArray();

        $posts = Post::with(['user:id,first_name,last_name', 'likes', 'reshares'])
            ->whereDoesntHave('hiddenByUsers', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->whereNotIn('user_id', $blockedUserIds) // Exclude posts from blocked users
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
