<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    protected $guarded = [];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
