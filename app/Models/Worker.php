<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contract_type',
        'job_titles',
        'description',
        'residence',
        'availability',
        'has_car',
        'work_experience',
        'languages',
        'has_hccp_certificate',
        'education',
    ];

    protected $casts = [
        'availability' => 'date',
        'has_car' => 'boolean',
        'has_hccp_certificate' => 'boolean',
    ];

    public function media()
    {
        return $this->belongsToMany(Media::class);
    }
}