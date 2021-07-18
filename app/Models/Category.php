<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $hidden = [];

    public function kategori()
    {
        return $this->belongsTo(Post::class, 'cat_id', 'id');
    }
}
