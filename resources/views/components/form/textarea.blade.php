@props([
    'label' => null,
    'name',
    'id' => null,
    'required' => false,
    'fullWidth' => true,
    'rows' => 3,
])

@php
    $id = $id ?? $name;
@endphp

<div class="flex flex-col gap-2 {{ $fullWidth ? 'col-span-2 max-[640px]:col-span-1' : '' }}">
    @if($label)
        <label for="{{ $id }}" class="text-[12px] font-bold text-gray-600 uppercase tracking-[0.5px]">
            {{ $label }} @if($required)<span class="text-red-600">*</span>@endif
        </label>
    @endif
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        {{ $attributes->except(['label', 'name', 'id', 'required', 'fullWidth', 'rows']) }}
        class="px-4 py-3 border border-gray-300 rounded-[10px] text-[14px] bg-gray-50 transition-all duration-300 outline-none focus:border-[#298752] focus:bg-white focus:shadow-[0_0_0_3px_rgba(41,135,82,0.1)]"
    >{{ $slot }}</textarea>
</div>
