<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = [
        'name',
        'is_mandatory'
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
    ];

    public function candidateDocuments()
    {
        return $this->hasMany(CandidateDocument::class);
    }
}
