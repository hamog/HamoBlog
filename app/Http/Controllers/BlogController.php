<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Post;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Contracts\Cookie\QueueingFactory as Cookie;
use Illuminate\Http\Request;
use Log;
use Mail;

class BlogController extends Controller
{
    /**
     * Showing Blog home page
     * @param PostRepository $post
     * @return  \View
     */
    public function home(PostRepository $post)
    {
        $posts = $post->with(['user'])->orderBy('published_at', 'des')->simplePaginate(9);
        return view('blog.home')->with('posts', $posts);
    }

    /**
     * Showing Blog about-me page.
     *
     * @return \View
     */
    public function about()
    {
        return view('blog.about');
    }

    /**
     * Showing Blog contact-me page.
     *
     * @return \View
     */
    public function contact()
    {
        return view('blog.contact');
    }

    /**
     * Get contact message and send email
     *
     * @param ContactRequest|Request $request
     * @return \Redirect
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
     * @param PostRepository $post
     * @param Cookie $cookie
     * @return \View
     */
    public function showPost($slug, PostRepository $post, Cookie $cookie)
    {
        $post = $post->slug($slug)->first();
        if (!$cookie->hasQueued('show_post')) {
            $post->increment('visit');
            $cookie->queue('show_post', true, 10);
        }
        return view('blog.post')->with('post', $post);
    }

    /**
     * Search posts with laravel scout.
     *
     * @param Request $request
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function search(Request $request)
    {
        // First we define the error message we are going to show if no keywords
        // existed or if no results found.
        //$error = ['error' => 'No results found, please try with different keywords.'];
        // Making sure the user entered a keyword.
        if($request->has('q')) {
            // Using the Laravel Scout syntax to search the products table.
            $posts = Post::search($request->get('q'))->get();
            // If there are results return them, if none, return the error message.
            //return $posts->count() ? $posts : $error;
            return $posts;
        }
        // Return the error message if no keywords existed
        //return $error;
    }
}
