<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'profile_picture',
        'description',
        'residence',
        'availability',
        'has_car',
        'work_experience',
        'languages',
        'has_hccp_certificate',
        'education'
    ];
}
