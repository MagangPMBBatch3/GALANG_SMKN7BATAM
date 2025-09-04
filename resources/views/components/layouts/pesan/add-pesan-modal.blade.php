<div id="addPesanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-6 border w-11/12 md:w-3/4 lg:w-1/2 shadow-xl rounded-xl bg-white">
        <div class="mt-3">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Kirim Pesan Baru</h3>
            <form id="addPesanForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Penerima</label>
                        <div class="relative mt-1">
                            <div id="addPenerimaDropdown" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 cursor-pointer bg-white flex items-center justify-between">
                                <span id="addPenerimaSelected" class="text-gray-500">Pilih Penerima</span>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" id="addPenerimaArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <div id="addPenerimaOptions" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <div id="addPenerimaList" class="p-2"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis</label>
                        <select name="jenis_id" id="addJenis" required class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Jenis</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Isi Pesan</label>
                        <textarea name="isi" rows="4" required class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" onclick="closeModal('addPesanModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>