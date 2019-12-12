<div class="search-bar">
    <input
        id="farhangSearchBar"
        wire:model="query"
        wire:keydown.arrow-up.prevent="upSuggestion"
        wire:keydown.arrow-down.prevent="downSuggestion"
        wire:keydown.enter="selectSuggestion"
        wire:keydown.escape="reset"
        autocomplete="false"
        autofocus
        class="{{ $results ? 'has-results' : '' }}"
    >
    @if($results)
        <ul class="autocomplete">
            @foreach($results as $i => $result)
                <li class="{{ $selectedSuggestion === $i ? 'list-selected' : '' }}">{{ $result['word'] }}</li>
            @endforeach
        </ul>
    @endif
    <div class="definition">
        {!! $definition !!}
    </div>
</div>
@push('scripts')
    <script>
        window.onkeypress = function(e) {
            if (e.key === '/') {
                e.preventDefault()
                document.getElementById('farhangSearchBar').focus()
            }
        }
    </script>
@endpush
