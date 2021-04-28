@props(['table', 'id', 'description'])

<div class="text-right text-sm leading-5 font-medium" wire:key="table-actions.{{ $id }}">
    @if ($table->resource()->can('view') && $table->resource()->actionEnabled('view'))
    <a href="{{ $table->showRoute($id) }}" class="inline-flex cursor-pointer">
        <!--heroicon-o-eye -->
        <svg class="text-gray-400 hover:text-gray-600 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
    </a>
    @endif

    @if ($table->resource()->can('update') && $table->resource()->actionEnabled('update'))
    <a href="{{ $table->editRoute($id) }}" class="inline-flex cursor-pointer" wire:loading.attr="disabled">
        <!-- heroicon-s-pencil -->
        <svg class="text-gray-400 hover:text-gray-600 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
        </svg>
    </a>
    @endif

    @if ($table->resource()->can('delete') && $table->resource()->actionEnabled('delete'))
    <a class="inline-flex cursor-pointer" wire:key="a-confirming.destroy.{{ $id }}">

        <!-- Logout Other Devices Confirmation Modal -->
        <x-move-dialog-modal wire:model="confirmingDestroy" show="'{{ $id }}'" show-type="===" key="confirming.destroy.{{ $id }}">
            <x-slot name="button">
                <div x-on:click="show = '{{ $id }}'">
                    <!-- heroicon-o-trash -->
                    <svg class="text-gray-400 hover:text-gray-600 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
            </x-slot>

            <x-slot name="title">@lang('Delete :resource', ['resource' => $description])</x-slot>

            <x-slot name="content">
                @lang('Are you sure you want to remove this :resource? This action cannot be undone.', ['resource' => $description . ' ' . ($title ?? $id)])
            </x-slot>

            <x-slot name="footer">
                <x-move-secondary-button
                    x-on:click="show = false"
                    wire:loading.attr="disabled"
                >@lang('Cancel')</x-move-secondary-button>

                <x-move-button
                    class="ml-2"
                    wire:click="destroy('{{ $id }}')"
                    wire:loading.attr="disabled"
                >@lang('Delete :resource', ['resource' => $table->resource()->singularLabel()])</x-move-button>
            </x-slot>
        </x-move-dialog-modal>
    </a>
    @endif
</div>
