<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextResponse extends Model
{
    use HasFactory;

    protected $table = 'text_responses';
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
