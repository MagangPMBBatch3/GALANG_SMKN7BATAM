<div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-xl font-semibold text-gray-900 mb-4">Proyek Terbaru</h3>
    <div class="scrollable-container">
        <div class="space-y-4">
            @php
                $recentProjects = \App\Models\Proyek\Proyek::latest()->take(10)->get();
            @endphp
            @foreach($recentProjects as $project)
                <div class="border-l-4 border-blue-500 pl-4 py-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $project->nama }}</h4>
                            <p class="text-sm text-gray-600">{{ Str::limit($project->nama_sekolah, 50) }}</p>
                        </div>
                        <span class="text-sm text-gray-500">{{ $project->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="mt-2">
                        @php
                            $totalTasks = \App\Models\JamKerja\JamKerja::where('proyek_id', $project->id)->count();
                            $completedTasks = \App\Models\JamKerja\JamKerja::where('proyek_id', $project->id)->where('status_id', 1)->count();
                            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                        @endphp
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Progress</span>
                            <span>{{ number_format($progress, 0) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>