<div class="search-bar">
    <input wire:model="query" autocomplete="false" autofocus class="{{ $results ? 'has-results' : '' }}">
    @if($results)
        <ul class="autocomplete">
            @foreach($results as $result)
                <li>{{ $result->word }}</li>
            @endforeach
        </ul>
    @endif
</div>
