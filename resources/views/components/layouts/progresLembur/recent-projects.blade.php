<div class="bg-white rounded-lg shadow-lg p-4 md:p-6 max-w-xs sm:max-w-sm md:max-w-screen-sm mx-auto px-4 py-6 md:py-8">
    <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-4">List Proyek</h3>
    <div class="scrollable-container">
        <div class="space-y-4">
            @php
                $recentProjects = \App\Models\Proyek\Proyek::latest()->take(10)->get();
            @endphp
            @forelse($recentProjects as $project)
                <div class="border-l-4 border-blue-500 pl-4 py-3 bg-gray-50 rounded-r-lg">
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-2">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 text-sm md:text-base truncate">{{ $project->nama }}</h4>
                            <p class="text-xs md:text-sm text-gray-600 truncate">{{ Str::limit($project->nama_sekolah, 60) }}</p>
                        </div>
                        <span class="text-xs md:text-sm text-gray-500 whitespace-nowrap">{{ $project->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="mt-3">
                        @php
                            $totalTasks = \App\Models\JamKerja\JamKerja::where('proyek_id', $project->id)->count();
                            $completedTasks = \App\Models\JamKerja\JamKerja::where('proyek_id', $project->id)->where('status_id', 1)->count();
                            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                        @endphp
                        <div class="flex justify-between text-xs md:text-sm text-gray-600 mb-1">
                            <span>Progress</span>
                            <span>{{ number_format($progress, 0) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada proyek</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada proyek yang tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>