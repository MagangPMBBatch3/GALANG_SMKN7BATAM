@props([
    'title' => '',
    'value' => 0,
    'subtext' => '',
    'subtextColor' => 'text-gray-600',
    'gradientFrom' => 'blue-50',
    'gradientTo' => 'blue-100'
])
<div class="bg-gradient-to-r from-{{ $gradientFrom }} to-{{ $gradientTo }} rounded-2xl p-6 text-center transform hover:scale-105 transition-transform">
    <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
    <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
    <p class="text-sm {{ $subtextColor }} mt-2">{{ $subtext }}</p>
</div>