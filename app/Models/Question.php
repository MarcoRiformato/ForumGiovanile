<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function election()
{
    return $this->belongsTo(Election::class);
}

public function options()
{
    return $this->hasMany(Option::class);
}

public function candidates()
{
    return $this->hasMany(Candidate::class);
}

public function votes()
{
    return $this->hasMany(Vote::class, 'question_id');
}

public function textResponses()
{
    return $this->hasMany(TextResponse::class);
}


}
