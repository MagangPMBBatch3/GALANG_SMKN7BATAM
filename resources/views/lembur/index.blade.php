<x-layouts.main title="Lembur">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Lembur</h1>
                <button onclick="openModal('addLemburModal')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Tambah Lembur
                </button>
            </div>

            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-100 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-800">Total Lembur</h3>
                    <p id="totalLembur" class="text-2xl font-bold text-blue-600">0</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800">Proyek Aktif</h3>
                    <p id="proyekAktif" class="text-2xl font-bold text-green-600">0</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-yellow-800">Lembur Hari Ini</h3>
                    <p id="lemburHariIni" class="text-2xl font-bold text-yellow-600">0</p>
                </div>
            </div>

            <div class="mb-4 flex space-x-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" id="filterTanggal" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Proyek</label>
                    <select id="filterProyek" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">Semua Proyek</option>
                    </select>
                </div>
                <button onclick="filterLembur()" class="mt-6 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Filter
                </button>
            </div>

            <div class="overflow-x-auto">
                <div class="scrollable-table-container">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyek</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="lemburTableBody" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 flex justify-between items-center">
                <div id="paginationInfo" class="text-sm text-gray-700">
                    Menampilkan 0 dari 0 data
                </div>
                <div id="paginationLinks" class="flex space-x-2">
                </div>
            </div>
        </div>
    </div>

    <div id="addLemburModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Tambah Lembur</h3>
                <form id="addLemburForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" required class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proyek</label>
                            <select id="addProyek" name="proyek_id" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Proyek</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" onclick="closeModal('addLemburModal')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
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

    <div id="editLemburModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Edit Lembur</h3>
                <form id="editLemburForm">
                    <input type="hidden" name="id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" required class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proyek</label>
                            <select id="editProyek" name="proyek_id" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Proyek</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" onclick="closeModal('editLemburModal')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
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

<script src="{{ asset('js/lembur/lembur.js') }}"></script>