<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisaProcess extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'visa_type',
        'application_date',
        'appointment_date',
        'reference_no',
        'accommodation_details',
        'status',
        'rejection_reason',
        'approval_date'
    ];

    protected $casts = [
        'application_date' => 'date',
        'appointment_date' => 'date',
        'approval_date' => 'date'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    /* Helper methods */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
