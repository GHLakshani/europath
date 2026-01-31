<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'ticket_no',
        'flight_no',
        'departure_date',
        'status',
        'remarks'
    ];

    protected $casts = [
        'departure_date' => 'date'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function isDeparted()
    {
        return $this->status === 'departed';
    }
}
