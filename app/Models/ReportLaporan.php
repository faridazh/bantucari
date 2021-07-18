<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportLaporan extends Model
{
    protected $fillable = [
        'cat_id',
        'post_id',
        'detail',
    ];

    protected $hidden = [];

    public function laporan()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function report_cat()
    {
        return $this->belongsTo(ReportCategory::class, 'cat_id', 'id');
    }
}
