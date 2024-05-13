<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Dormitory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function announcement() {

        $posts = Post::orderBy('id', 'desc')->paginate(5);
        $postIds = $posts->pluck('id')->toArray();

        $comments = Comment::whereIn('post_id', $postIds)->get();
        $dorms = Dormitory::all();

        return view('announcement.index', compact('posts','comments','dorms'));

    }
    
    public function add_comment(Request $request ,$id) {

        $request->validate([
            'content' => 'required',
        ]);

        $comment = new Comment;
        $comment->content = $request->content;
        $comment->post_id = $id;
        $comment->user_id = Auth::user()->id;
        $comment->admin_id = null;
        $comment->save();

        return redirect()->back()->with('success', 'Comment has been created!');
    }

    public function delete_comment($id) {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    // public function index() {
    //     $data['posts'] = Post::orderBy('id', 'asc')->paginate(5);
    //     return view('posts.index', $data);
    // }

    // // Create Post
    // public function create() {
    //     return view('posts.create');
    // }


    // // Store Post
    // public function store(Request $request) {
    //     $request->validate([
    //         'title' => 'required',
    //         'content' => 'required',
    //     ]);

    //     $post = new Post;
    //     $post->title = $request->title;
    //     $post->content = $request->content;
    //     $post->save();

    //     return redirect()->route('posts.index')->with('success', 'Post has been created!');
    // }

    // // Edit Post
    // public function edit(Post $post) {
    //     return view('posts.edit', compact('post'));
    // }

    // // Update Post
    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'title' => 'required',
    //         'content' => 'required',
    //     ]);

    //     $post = Post::find($id);
    //     $post->title = $request->title;
    //     $post->content = $request->content;
    //     $post->save();

    //     return redirect()->route('posts.index')->with('success', 'Post has been updated!');
    // }

    // // Delete Post
    // public function destroy(Post $post){
    //     $post->delete();
    //     return redirect()->route('posts.index')->with('success', 'Post has been deleted!');
    // }
}
