@props(['userProfile'])
<div class="mt-8">
    <h3 class="text-xl font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
    <div class="space-y-4">
        @php
            $recentTasks = \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->latest()->take(3)->get();
        @endphp
        @foreach($recentTasks as $task)
            <div class="border-l-4 border-indigo-500 pl-4 py-3 bg-gray-50 rounded-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $task->proyek->nama ?? '-' }}</h4>
                        <p class="text-sm text-gray-600">{{ $task->aktivitas->nama ?? '-' }}</p>
                    </div>
                    <span class="text-sm text-gray-500">{{ $task->created_at->diffForHumans() }}</span>
                </div>
                <div class="mt-2">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Status</span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->status_id == 1 ? 'bg-green-100 text-green-800' : ($task->status_id == 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $task->status->nama ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
        @if($recentTasks->isEmpty())
            <div class="text-center text-gray-500 p-4 bg-gray-50 rounded-lg">
                Tidak ada aktivitas terbaru
            </div>
        @endif
    </div>
</div>