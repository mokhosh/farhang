<div class="search-bar">
    <input id="farhangSearchBar" wire:model="query" autocomplete="false" autofocus class="{{ $results ? 'has-results' : '' }}">
    @if($results)
        <ul class="autocomplete">
            @foreach($results as $result)
                <li>{{ $result->word }}</li>
            @endforeach
        </ul>
    @endif
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
