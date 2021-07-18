<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KendaraanHilang extends Model
{
    protected $fillable = [
        'post_id',
        
        'case_code',

        'photo',
        'fullname',
        'platnomor',
        'tanggal',
        'jenis',
        'tempatakhir',
        'ciri',
        'kronologi',
    ];

    protected $hidden = [];

    protected $casts = [
        'photo' => 'array',
    ];

    public function laporan()
    {
        return $this->belongsTo(Post::class, 'id', 'post_id');
    }
}
