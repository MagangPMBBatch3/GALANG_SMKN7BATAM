<div class="p-4 border-t border-gray-200 bg-white">
    <form id="sendMessageForm" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 items-stretch sm:items-center">
        <input type="hidden" name="penerima_id" id="currentPenerimaId">
        <select name="jenis_id" id="sendJenis" class="w-full sm:w-1/4 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-2 px-3">
            <option value="">Pilih Jenis</option>
        </select>
        <input type="text" name="isi" placeholder="Ketik pesan..." class="flex-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 outline-none">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
            Kirim
        </button>
    </form>
</div>