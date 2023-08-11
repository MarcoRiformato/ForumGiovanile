<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class media extends Model
{
    use HasFactory;
    protected $fillable = ['filename', 'filepath', 'filetype', 'article_id'];



    public function articles() {
        return $this->belongsToMany(Article::class);
    }    
    
}
