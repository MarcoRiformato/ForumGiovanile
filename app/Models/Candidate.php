<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function elections()
    {
        return $this->belongsToMany(Election::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function votes()
{
    return $this->hasMany(Vote::class, 'candidate_id', 'id');
}
}

