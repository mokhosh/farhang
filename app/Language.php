<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = [];

    public function dictionaries()
    {
        return $this->hasMany(Dictionary::class);
    }
}
