<x-layouts.main title="Dashboard">
    <div class="bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 shadow-md">
                    <img id="userProfileFoto" src="" alt="Profile Photo" class="w-full h-full object-cover hidden">
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Selamat datang, <span id="userProfileNamaLengkap">{{ Auth::user()->nama_lengkap ?? 'User' }}</span></h1>
                    <p class="text-blue-100 text-lg">Sistem manajemen proyek</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-white">
                    <p class="text-sm opacity-75">Hari ini</p>
                    <p class="text-2xl font-bold">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Proyek</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Proyek\Proyek::count() }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 font-medium">+{{ \App\Models\Proyek\Proyek::where('created_at', '>=', now()->subDays(30))->count() }} baru bulan ini</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tugas Aktif</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\JamKerja\JamKerja::where('status_id', '!=', 5)->count() }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-600">{{ \App\Models\JamKerja\JamKerja::where('status_id', 3)->count() }} dalam proses</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tugas Selesai</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\JamKerja\JamKerja::where('status_id', 1  )->count() }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-600">{{ \App\Models\JamKerja\JamKerja::where('status_id', 1)->where('updated_at', '>=', now()->subDays(30))->count() }} selesai bulan ini</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Anggota Tim</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User\User::count() }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-600">{{ \App\Models\User\User::where('created_at', '>=', now()->subDays(30))->count() }} baru bulan ini</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Proyek Terbaru</h3>
            <div class="space-y-4">
                @php
                    $recentProjects = \App\Models\Proyek\Proyek::latest()->take(5)->get();
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
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('progres.kerja') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <div>
                    <p class="font-semibold text-gray-900">Lihat Progres</p>
                    <p class="text-sm text-gray-600">Kelola semua tugas</p>
                </div>
            </a>
            
            <a href="{{ route('proyek') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <div>
                    <p class="font-semibold text-gray-900">Proyek</p>
                    <p class="text-sm text-gray-600">Kelola proyek</p>
                </div>
            </a>
            
            <a href="{{ route('aktivitas') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <div>
                    <p class="font-semibold text-gray-900">Aktivitas Baru</p>
                    <p class="text-sm text-gray-600">Tambahkan aktivitas</p>
                </div>
            </a>
        </div>
    </div>

    <script>
        window.authUserId = {{ Auth::id() }};
    </script>
    <script src="{{ asset('js/userprofile/userprofile.js') }}"></script>
</x-layouts.main>