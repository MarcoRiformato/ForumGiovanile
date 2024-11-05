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
        'descrizione',
        'isCorso'
    ];
}
