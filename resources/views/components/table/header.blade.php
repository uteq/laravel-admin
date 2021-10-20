@props(['title', 'table', 'add-url', 'add-action', 'add-is-route' => false, 'add-text', 'search' => false, 'hideAddAction' => false])

<div class="-ml-4 -mt-2 flex items-end justify-between flex-wrap sm:flex-no-wrap">
    <div class="ml-4 mt-2 {{ $search ? '' : 'mb-12' }} flex gap-2 items-center">
        {!! $beforeSearch ?? null !!}

        @if ($search && $table->meta('with_search'))
        <div class="flex items-center relative mt-3 w-full text-gray-400 focus-within:text-gray-600">
            <div class="absolute inset-y-0 left-2 flex items-center pointer-events-none">
                <div wire:loading wire:target="search">
                    <!--x-css-spinner-->
                    <svg class="h-5 w-5 animate-spin" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="currentColor"></path>
                        <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                    </svg>
                </div>
                <div wire:loading.remove wire:target="search">
                    <!--heroicon-o-search-->
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <input id="search_field"
                   class="border-none shadow block w-full h-full pl-10 pr-3 py-2 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 text-sm"
                   placeholder="Search"
                   type="search"
                   wire:model="filter.search"
            />
        </div>
        @endif

        {!! $afterSearch ?? null !!}
    </div>
    <div class="ml-4 sm:ml-0 flex gap-2 items-center">
        {!! $beforeAdd ?? null !!}

        @if (! $hideAddAction)
            @if ($addIsRoute)
                <x-move-a button href="{{ $addAction }}" class="font-black">{{ $addText }}</x-move-a>
            @else
                <x-move-button wire:click="{{ $addAction }}" class="font-black">{{ $addText }}</x-move-button>
            @endif
        @endif

        {!! $afterAdd ?? null !!}
    </div>
</div>
