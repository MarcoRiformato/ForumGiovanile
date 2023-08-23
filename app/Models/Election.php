<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;
    protected $table = 'elections';
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the votes for the election.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the user that created the election.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check if the election is open.
     *
     * @return bool
     */
    public function isOpen()
    {
        return $this->status === 'open';
    }

    /**
     * Check if the election is closed.
     *
     * @return bool
     */
    public function isClosed()
    {
        return $this->status === 'closed';
    }

    /**
     * Check if the election is upcoming.
     *
     * @return bool
     */
    public function isUpcoming()
    {
        return $this->status === 'upcoming';
    }
}
