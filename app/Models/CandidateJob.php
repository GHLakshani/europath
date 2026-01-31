<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateJob extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country_id',
        'title',
        'order',
        'status',
        'is_active'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
