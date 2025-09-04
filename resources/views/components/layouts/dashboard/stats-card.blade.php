@props([
    'title' => '',
    'value' => 0,
    'icon' => '',
    'iconColor' => 'blue-600',
    'bgColor' => 'blue-100',
    'subtext' => '',
    'subtextColor' => 'text-gray-600'
])
<div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
        </div>
        <div class="p-3 bg-{{ $bgColor }} rounded-full">
            <svg class="w-8 h-8 text-{{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        </div>
    </div>
    <div class="mt-4">
        <span class="text-sm {{ $subtextColor }} font-medium">{{ $subtext }}</span>
    </div>
</div>