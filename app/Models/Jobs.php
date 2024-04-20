<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;

    protected $fillable = [
        'lavoro',
        'imageUrl',
        'azienda',
        'luogo',
        'stipendio',
        'data_pubblicazione',
        // Add any other fields that you want to be mass-assignable.
    ];
}
