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
            return back()->with('success', 'Your message is successfully sent.');
        } catch(Exception $e) {
            Log::debug('Sending Contact mail : '. $e->getMessage());
            return back()->with('error', 'Failed! Your message mail sending failed.');
        }
    }

    /**
     * Showing blog post.
     *
     * @param string $slug
     * @param Cookie $cookie
     * @param Request $request
     * @return response view
     */
    public function showPost($slug, Cookie $cookie, Request $request)
    {
        $post = Post::slug($slug)->first();
        if (!$cookie->hasQueued('show_post')) {
            $post->increment('visit');
            $cookie->queue('show_post', true, 10);
        }
        return view('blog.post')->with('post', $post);
    }
}
