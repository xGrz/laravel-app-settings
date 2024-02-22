@props(['type' => 'info', 'class' => ''])

@php
    $typeClass = [
            'info' => 'text-blue-800 bg-blue-100 border-2 border-blue-200',
            'success' => 'text-green-800 bg-green-100 border-2 border-green-200',
            'warning' => 'text-orange-800 bg-orange-100 border-2 border-orange-200',
            'error' => 'text-red-800 bg-red-200 border-2 border-red-200',
            ]
@endphp

<div {{ $attributes->merge(['class' => "p-4 mb-4 text-sm rounded-lg $typeClass[$type] $class"]) }}>
    {{ $slot }}
</div>
