<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display a user's profile and their posts.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $userId = auth()->id();

        // Check if the authenticated user has blocked the profile user or vice versa
        $isBlocked = User::where('id', $userId)
            ->whereHas('blockedUsers', function ($query) use ($id) {
                $query->where('blocked_user_id', $id);
            })
            ->exists() || User::where('id', $id)
            ->whereHas('blockedUsers', function ($query) use ($userId) {
                $query->where('blocked_user_id', $userId);
            })
            ->exists();

        if ($isBlocked) {
            return redirect()->route('dashboard')->with('message', 'You are not allowed to view this profile.');
        }

        $user = User::with(['posts.user'])->findOrFail($id);

        $posts = Post::with(['user:id,first_name,last_name', 'likes', 'reshares'])
            ->whereDoesntHave('hiddenByUsers', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->where('user_id', $id)
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

        return Inertia::render('Profile/Index', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function blockUser(Request $request, $userId)
    {
        $user = auth()->user();
        $user->blockedUsers()->attach($userId);

        return redirect()->back()->with('message', 'User blocked successfully.');
    }

    public function unblockUser(Request $request, $userId)
    {
        $user = auth()->user();
        $user->blockedUsers()->detach($userId);

        return redirect()->back()->with('message', 'User unblocked successfully.');
    }
}
