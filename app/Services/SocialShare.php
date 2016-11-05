<?php

namespace App\Services;


use Request;

class SocialShare
{
    /**
     * Full URL of page.
     *
     * @var string
     */
    protected $url;

    /**
     * Social networks share urls.
     *
     * @var array
     */
    protected $links;

    public function __construct()
    {
        $this->url = Request::fullUrl();
        $this->links = [
            'twitter'   => "http://www.twitter.com/share?url={$this->url}",
            'facebook'  => "http://www.facebook.com/sharer.php?u={$this->url}",
            'telegram'  => "https://telegram.me/share/url?url={$this->url}",
            'google'    => "http://plus.google.com/share?url={$this->url}",
        ];
    }

    public function make($social)
    {
        $url = $this->makeUrl($social);
        $html = <<<BUTTON
        <a class="btn btn-social-icon btn-$social" target="_blank" href="$url">
            <span class="fa fa-$social"></span>
        </a>
BUTTON;
        return $html;
    }

    /**
     * Make social network url.
     *
     * @param $social
     * @return string
     */
    private function makeUrl($social)
    {
        return $this->links[$social];
    }
}