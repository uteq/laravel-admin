@props(['title' => null, 'borderPosition' => 'top', 'color' => 'teal', 'hideIcon' => false, 'withoutPadding' => false, 'borderColor' => null])

@php

    $borderClass = [
        'top' => 'border-t-4',
        'left' => 'border-l-4',
        'right' => 'border-r-4',
        'bottom' => 'border-b-4',
    ][$borderPosition];

@endphp

<div {{ $attributes->merge([
        'class' => 'bg-' . $color .'-100 '. $borderClass . ' ' . ($borderColor ?: 'border-' . $color .'-500') . ' rounded-b text-' . $color .'-900 '. ($withoutPadding ? 'px-4 py-3' : null) .' shadow-md'
     ]) }}
     role="alert"
>
    <div class="{{ $hideIcon ?: 'flex' }}">
        @if (! $hideIcon)
        <div class="py-1"><svg class="fill-current h-6 w-6 text-{{ $color }}-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
        @endif
        <div>
            @if ($title)
                <p class="font-bold">{{ $title }}</p>
            @endif
            <p class="text-sm">{!! $slot !!}</p>
        </div>
    </div>
</div>
