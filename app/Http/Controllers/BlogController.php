<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Post;
use App\User;
use Cache;
use Exception;
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
        $posts = Cache::remember('posts', 60, function () {
            return Post::with('user', 'tags')->visible()->paginate(10);
        });
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
}
