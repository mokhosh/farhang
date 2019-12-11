<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function dictionary()
    {
        return $this->belongsTo(Dictionary::class);
    }
}
