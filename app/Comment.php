<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'comment',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean',
    ];

    /**
     * Add confirmed Global scope for comments
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('confirmed', function (Builder $builder) {
            $builder->where('confirmed', 1);
        });
    }


    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the comment that owns the reply comment.
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the reply comment associated with the comment.
     */
    public function reply()
    {
        return $this->hasOne(Comment::class, 'parent_id');
    }
}
