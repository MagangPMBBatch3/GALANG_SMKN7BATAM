@props([
    'title' => '',
    'id' => '',
    'value' => '0',
    'bgColor' => 'blue-100',
    'textColor' => 'blue-800',
    'valueColor' => 'blue-600'
])
<div class="bg-{{ $bgColor }} p-4 rounded-lg">
    <h3 class="text-lg font-semibold text-{{ $textColor }}">{{ $title }}</h3>
    <p id="{{ $id }}" class="text-2xl font-bold text-{{ $valueColor }}">{{ $value }}</p>
</div>