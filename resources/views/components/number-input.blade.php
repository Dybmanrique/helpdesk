@props(['disabled' => false, 'value' => '', 'model' => null])
{{-- value: se usará cuando NO se use livewire; y, model: se usará cuando se use livewire --}}
<div
    @if ($model) x-data="{ number: $wire.entangle('{{ $model }}') }" @else x-data="{ number: @js($value) }" @endif class="w-full">
    <input x-model="number" @disabled($disabled)
        @input="number = number.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
        {{ $attributes->merge([
            'value' => !$model ? $value : null,
            'class' =>
                'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:text-gray-500 dark:disabled:text-gray-400 dark:disabled:bg-gray-700',
        ]) }}>
</div>
