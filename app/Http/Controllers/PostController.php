<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return Inertia::render('Dashboard', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = new Post();
        $post->content = $request->content;
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->back()->with('message', 'Post created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $posts = Post::where('user_id', $id)->with('user:id,name')->get();
        return Inertia::render('Profile/Posts', ['posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post->content = $validatedData['content'];
        $post->save();

        return redirect()->route('dashboard')->with('message', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('message', 'Post deleted successfully!');
    }

    public function like(Request $request, Post $post)
    {
        $post->likes()->create([
            'user_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Post liked successfully!');
    }

    public function unlike(Request $request, Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();

        return redirect()->back()->with('success', 'Like removed successfully!');
    }

    public function reshare(Request $request, Post $post)
    {
        $post->reshares()->create([
            'user_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Post reshared successfully!');
    }

    public function removereshare(Request $request, Post $post)
    {
        $post->reshares()->where('user_id', auth()->id())->delete();

        return redirect()->back()->with('success', 'Reshare removed successfully!');
    }
}
