@props([
    'label',
    'name',
    'id' => null,
    'required' => false,
    'format' => 'PDF, PNG, JPG (Maks. 5MB)',
    'currentFile' => null,
    'currentFileLabel' => 'Lihat Berkas',
])

@php
    $id = $id ?? $name;
@endphp

<div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-5 flex flex-col gap-2.5">
    <label for="{{ $id }}" class="font-bold text-[13px] text-gray-700">
        {{ $label }} @if($required)<span class="text-red-600">*</span>@endif
    </label>
    <input
        type="file"
        name="{{ $name }}"
        id="{{ $id }}"
        @if($required) required @endif
        {{ $attributes->except(['label', 'name', 'id', 'required', 'format', 'currentFile', 'currentFileLabel']) }}
        class="text-[12px]"
    >
    <p class="text-[10px] text-gray-400">Format: {{ $format }}</p>
    @if($currentFile)
        <div class="text-[11px] mt-1 bg-[#298752]/[0.06] p-1.5 rounded-md">
            📂 Berkas saat ini: <a href="{{ asset($currentFile) }}" target="_blank" class="text-[#298752] font-bold underline">{{ $currentFileLabel }}</a>
        </div>
    @endif
</div>
