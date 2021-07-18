<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportMember extends Model
{
    protected $fillable = [
        'cat_id',
        'user_id',
        'detail',
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function report_cat()
    {
        return $this->belongsTo(ReportCategory::class, 'cat_id', 'id');
    }
}
