<?php

namespace App\Http\Livewire;

use App\Entry;
use Livewire\Component;
use Livewire\PassPublicPropertiesToView;
use Spatie\String\Str;

class SearchBar extends Component
{
    use PassPublicPropertiesToView;

    public $query = '';
    public $definition = '';
    public $results = [];
    public $selectedSuggestion = 0;
    protected $suggestionCount = 10;

    protected function query()
    {
        $normalized = new Str($this->query);
        $normalized = $normalized->trim();
        $normalized = $normalized->replace('ی','ي');
        return $normalized;
    }

    public function reset()
    {
        $this->query = '';
        $this->definition = '';
        $this->results = [];
        $this->selectedSuggestion = 0;
    }

    public function updatedQuery()
    {
        $this->results = $this->query ? Entry::where('word', 'like', $this->query() . '%')->limit($this->suggestionCount)->get()->toArray() : [];
    }

    public function downSuggestion()
    {
        if ($this->selectedSuggestion === count($this->results) - 1) {
            $this->selectedSuggestion = 0;
            return;
        }
        $this->selectedSuggestion++;
    }

    public function upSuggestion()
    {
        if ($this->selectedSuggestion === 0) {
            $this->selectedSuggestion = count($this->results) - 1;
            return;
        }
        $this->selectedSuggestion--;
    }

    public function selectSuggestion()
    {
        $word = $this->results[$this->selectedSuggestion] ?? null;

        if ($word) {
            $this->definition = $word['definition'];
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
