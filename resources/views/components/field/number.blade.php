@props(['disabled' => false, 'model' => null])

@php
    $modelId = $model ?: $attributes->wire('model')->value();
@endphp

<input {{ $disabled ? 'disabled' : '' }}
    id="{{ $modelId }}"
    type="number"

    @if ($attributes->wire('model')->value())
         {{ $attributes->wire('model') }}
    @else
         wire:model="{{ $model }}"
    @endif

    autocomplete="{{ $model }}"
    {!! $attributes->merge([
        'type' => 'text',
        'class' => 'flex-1 form-input block w-full min-w-0 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 border-gray-300'
    ]) !!}
/>
