<x-layouts.main title="Progress Kerja">
    <div class="max-w-xs sm:max-w-sm md:max-w-screen-sm mx-auto px-4 py-6 md:py-8">
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Progress Kerja</h1>
                <button onclick="openModal('addProgressModal')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm md:text-base w-full sm:w-auto">
                    Tambah Progress
                </button>
            </div>

            <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-100 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-800">Total Jam Kerja</h3>
                    <p id="totalJam" class="text-2xl font-bold text-blue-600">0</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800">Proyek Aktif</h3>
                    <p id="proyekAktif" class="text-2xl font-bold text-green-600">0</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-yellow-800">Progress Hari Ini</h3>
                    <p id="progressHariIni" class="text-2xl font-bold text-yellow-600">0</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-purple-800">Persentase Selesai</h3>
                    <p id="persentaseSelesai" class="text-2xl font-bold text-purple-600">0%</p>
                </div>
            </div>

            <div class="mb-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" id="filterTanggal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Proyek</label>
                        <select id="filterProyek" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Proyek</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="filterStatus" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button onclick="filterProgress()" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <div id="progressCardsContainer" class="grid grid-cols-1 gap-4 max-h-[400px] overflow-y-auto">
            </div>

            <div class="mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div id="paginationInfo" class="text-xs sm:text-sm text-gray-700">
                    Menampilkan 0 dari 0 data
                </div>
                <div id="paginationLinks" class="flex flex-wrap gap-1 sm:gap-2">
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-xs sm:max-w-sm md:max-w-screen-sm mx-auto px-4 py-6 md:py-8">
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
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
    </div>

    <div id="addProgressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Tambah Progress Kerja</h3>
                <form id="addProgressForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" required class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proyek</label>
                            <select id="addProyek" name="proyek_id" required class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Proyek</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Aktivitas</label>
                            <select id="addAktivitas" name="aktivitas_id" required class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Aktivitas</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jam Kerja</label>
                            <input type="number" step="0.5" name="jumlah_jam" required class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="addStatus" name="status_id" required class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Status</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mode</label>
                            <select id="addMode" name="mode_id" required class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Mode</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" onclick="closeModal('addProgressModal')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editProgressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-4 md:top-20 mx-auto p-4 md:p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Edit Progress Kerja</h3>
                <form id="editProgressForm">
                    <input type="hidden" name="id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" required class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proyek</label>
                            <select id="editProyek" name="proyek_id" required class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Proyek</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Aktivitas</label>
                            <select id="editAktivitas" name="aktivitas_id" required class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Aktivitas</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jam Kerja</label>
                            <input type="number" step="0.5" name="jumlah_jam" required class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="editStatus" name="status_id" required class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Status</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mode</label>
                            <select id="editMode" name="mode_id" required class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Mode</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" onclick="closeModal('editProgressModal')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.main>

<script src="{{ asset('js/progres-kerja/progres-kerja.js') }}"></script>