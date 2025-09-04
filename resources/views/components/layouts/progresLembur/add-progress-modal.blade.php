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