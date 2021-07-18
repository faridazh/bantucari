<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelapor extends Model
{
    protected $fillable = [
        'post_id',

        'case_code',

        'nama_pelapor',
        'hubungi_pelapor',
        'email_pelapor',
        'alamat_pelapor',
    ];

    protected $hidden = [];
}
