<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'payment_type',
        'amount',
        'payment_date',
        'receipt_no',
        'remarks'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
