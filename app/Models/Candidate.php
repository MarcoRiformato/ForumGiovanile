<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    public function elections()
{
    return $this->belongsToMany(Election::class);
}

public function question()
{
    return $this->belongsTo(Question::class);
}


}
