@props(['disabled' => false, 'model' => null, 'updating' => null, 'debounce' => '500ms', 'hasError' => false])

@php
    $modelId = $model ?: $attributes->wire('model')->value();
@endphp

<input {{ $disabled ? 'disabled' : '' }}
    id="{{ $modelId }}"

    @if ($attributes->wire('model')->value())
        {{ $attributes->wire('model') }}
    @else
        wire:model.lazy="{{ $model }}"
    @endif

    autocomplete="{{ $modelId }}"

    {!! $attributes->merge([
        'type' => 'text',
        'class' => 'flex-1 form-input block w-full min-w-0 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 rounded ' . ( ! $disabled ?: 'bg-gray-300' ) . ' ' . ( $hasError ? 'border-red-500' : 'border-gray-300' )
    ]) !!}
/>
