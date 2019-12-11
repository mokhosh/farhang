<?php

namespace App\Http\Livewire;

use App\Entry;
use Livewire\Component;
use Spatie\String\Str;

class SearchBar extends Component
{
    public $query = '';

    protected function query()
    {
        $normalized = new Str($this->query);
        $normalized = $normalized->trim();
        $normalized = $normalized->replace('ی','ي');
        return $normalized;
    }

    public function render()
    {
        return view('livewire.search-bar', [
            'results' => $this->query ? Entry::where('word', 'like', $this->query() . '%')->limit(10)->get() : [],
        ]);
    }
}
