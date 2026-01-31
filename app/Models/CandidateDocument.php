<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateDocument extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'document_type_id',
        'is_submitted',
        'submitted_date'
    ];

    protected $casts = [
        'is_submitted' => 'boolean',
        'submitted_date' => 'date'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
