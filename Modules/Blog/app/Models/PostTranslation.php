<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'locale',
        'post_id',
        'description'
    ];

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
