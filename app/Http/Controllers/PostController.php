<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function deletePost(Post $post)
    {
        if (auth()->user()->id === $post->user_id) {
            $post->delete();
            return redirect('/')->with('message', 'Post deleted successfully.');
        }
        
        return back()->withErrors(['unauthorized' => 'You are not authorized to delete this post.']);
    }

    public function updatePost(Post $post, Request $request)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/')->withErrors(['unauthorized' => 'You are not authorized to update this post.']);
        }

        $incomingFields = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        // Sanitize input
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['content'] = strip_tags($incomingFields['content']);

        // Update the post
        $post->update($incomingFields);

        return redirect('/')->with('message', 'Post updated successfully.');
    }

    public function showEdit(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }

    public function create(Request $request)
    {
        // Validate and sanitize the incoming request fields
        $incomingFields = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['content'] = strip_tags($incomingFields['content']);
        $incomingFields['user_id'] = auth()->id(); // Assign the logged-in user's ID

        // Create the post
        Post::create($incomingFields);

        // Redirect to homepage with success message
        return redirect('/')->with('message', 'Post created successfully.');
    }

    public function login(Request $request)
    {
        // Validate the login form data
        $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['name' => $request->loginname, 'password' => $request->loginpassword])) {
            // Redirect to homepage if login is successful
            return redirect('/')->with('message', 'Logged in successfully.');
        }

        // If login fails, return with an error message
        return back()->withErrors([
            'loginerror' => 'Invalid login credentials. Please try again.',
        ])->withInput();
    }
}
?>