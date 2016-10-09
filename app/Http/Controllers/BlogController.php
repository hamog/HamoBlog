<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Post;
use Exception;
use Illuminate\Contracts\Cookie\QueueingFactory as Cookie;
use Illuminate\Http\Request;
use Log;
use Mail;

class BlogController extends Controller
{
    /**
     * Showing Blog home page
     */
    public function home()
    {
//        $posts = Cache::remember('posts', 60, function () {
//            return Post::visible()->latest()->paginate(9);
//        });
        $posts = Post::visible()->latest()->simplePaginate(9);
        return view('blog.home')->with('posts', $posts);
    }

    /**
     * Showing Blog about-me page
     */
    public function about()
    {
        return view('blog.about');
    }

    /**
     * Showing Blog contact-me page
     */
    public function contact()
    {
        return view('blog.contact');
    }

    /**
     * Get contact message and send email
     *
     * @param ContactRequest|Request $request
     * @return string
     */
    public function sendContact(ContactRequest $request)
    {
        try {
            Mail::to(config('mail.from.address'))
                ->send(new ContactMail($request));
            alert()->success('Success', 'Your message is successfully sent.');
            return redirect()->route('contact');
        } catch(Exception $e) {
            Log::debug('Sending Contact mail : '. $e->getMessage());
            alert()->error('Error!', 'Your message mail sending failed.');
            return back()->withInput();
        }
    }

    /**
     * Showing blog post.
     *
     * @param string $slug
     * @param Cookie $cookie
     * @return response view
     */
    public function showPost($slug, Cookie $cookie)
    {
        $post = Post::slug($slug)->first();
        if (!$cookie->hasQueued('show_post')) {
            $post->increment('visit');
            $cookie->queue('show_post', true, 10);
        }
        return view('blog.post')->with('post', $post);
    }

    public function search(Request $request)
    {
        // First we define the error message we are going to show if no keywords
        // existed or if no results found.
        $error = ['error' => 'No results found, please try with different keywords.'];
        // Making sure the user entered a keyword.
        if($request->has('q')) {
            // Using the Laravel Scout syntax to search the products table.
            $posts = Post::search($request->get('q'))->get();
            // If there are results return them, if none, return the error message.
            return $posts->count() ? $posts : $error;
        }
        // Return the error message if no keywords existed
        return $error;
    }
}
