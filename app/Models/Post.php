<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'cat_id',

        'case_code',
        'slug',

        'status',
        'verify',
    ];

    protected $hidden = [];

    protected $casts = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function kategori()
    {
        return $this->hasOne(Category::class, 'id', 'cat_id');
    }

    public function laporan($cat_id)
    {
        if ($cat_id == 1) {
            $data = $this->hasOne(BarangHilang::class, 'post_id', 'id')->first();
        }
        elseif ($cat_id == 2) {
            $data = $this->hasOne(KendaraanHilang::class, 'post_id', 'id')->first();
        }
        elseif ($cat_id == 3) {
            $data = $this->hasOne(OrangHilang::class, 'post_id', 'id')->first();
        }

        return $data;
    }
}
