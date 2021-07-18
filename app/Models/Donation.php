<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'donor_id',
        'donor_name',
        'donor_mail',
        'donation_type',
        'donor_amount',
        'donor_note',
        'donor_status',
        'snap_token',
    ];

    public function statusPending()
    {
        $this->attributes['donor_status'] = 'pending';
        $this->save();
    }

    public function statusSuccess()
    {
        $this->attributes['donor_status'] = 'success';
        $this->save();
    }

    public function statusFailes()
    {
        $this->attributes['donor_status'] = 'failed';
        $this->save();
    }

    public function statusExpired()
    {
        $this->attributes['donor_status'] = 'expired';
        $this->save();
    }

    public function statusCanceled()
    {
        $this->attributes['donor_status'] = 'canceled';
        $this->save();
    }
}
