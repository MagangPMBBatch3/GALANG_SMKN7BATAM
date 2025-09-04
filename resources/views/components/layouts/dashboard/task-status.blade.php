<div class="bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-xl font-semibold text-gray-900 mb-4">Status Tugas</h3>
    <div class="space-y-3">
        @php
            $statusCounts = \App\Models\JamKerja\JamKerja::with('status')
                ->get()
                ->groupBy('status.nama')
                ->map->count();
        @endphp
        @foreach($statusCounts as $status => $count)
            <div class="flex justify-between items-center">
                <span class="text-gray-700">{{ $status }}</span>
                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-sm">{{ $count }}</span>
            </div>
        @endforeach
    </div>
    <div class="mt-6 pt-6 border-t">
        <h4 class="font-semibold text-gray-900 mb-3">Ringkasan Bulan Ini</h4>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">Tugas Baru:</span>
                <span class="font-medium">{{ \App\Models\JamKerja\JamKerja::where('created_at', '>=', now()->subDays(30))->count() }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Selesai:</span>
                <span class="font-medium">{{ \App\Models\JamKerja\JamKerja::where('status_id', 1)->where('updated_at', '>=', now()->subDays(30))->count() }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Dalam Proses:</span>
                <span class="font-medium">{{ \App\Models\JamKerja\JamKerja::where('status_id', 3)->count() }}</span>
            </div>
        </div>
    </div>
</div>