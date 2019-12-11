<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
