<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = [];

    public function sourceDictionaries()
    {
        return $this->hasMany(Dictionary::class, 'source_language_id');
    }

    public function targetDictionaries()
    {
        return $this->hasMany(Dictionary::class, 'target_language_id');
    }
}
