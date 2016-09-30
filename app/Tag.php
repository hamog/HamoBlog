<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The post that belong to the tag.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
    
    /**
     * Store new tags into database
     *
     * @param array $tags
     * @return array
     */
    public function storeNewTags($tags)
    {
        foreach ($tags as $key => $tag) {
            if (ctype_digit($tag))
                continue;
            //store new tag
            $newTag = $this->firstOrCreate(['name' => $tag]);
            $tags[] = $newTag->id;
            unset($tags[$key]);
        }
        return $tags;
    }
}
