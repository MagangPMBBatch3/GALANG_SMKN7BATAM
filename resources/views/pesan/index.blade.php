<x-layouts.main title="Pesan">
    <div class="container mx-auto h-screen flex flex-col bg-gray-50">
        <div class="flex flex-1 overflow-hidden">
            <div class="w-1/3 bg-white shadow-md border-r border-gray-200 overflow-y-auto">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4 text-white sticky top-0 z-10">
                    
                    <h1 class="text-2xl font-bold">Pesan</h1>
                    <button onclick="openModal('addPesanModal')" class="mt-2 bg-white text-blue-600 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-100 transition-colors">
                        Pesan Baru
                    </button>
                </div>
                <div id="conversationList" class="divide-y divide-gray-100">
                </div>
            </div>
            <div class="w-2/3 flex flex-col bg-white">
                <div id="chatHeader" class="bg-white p-4 border-b border-gray-200 flex items-center shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800">Pilih Penerima untuk Memulai</h2>
                </div>
                <div id="chatMessages" class="flex-1 p-6 overflow-y-auto relative bg-gray-50">
                    <div id="loadingIndicator" class="hidden text-center text-gray-500 p-4">Memuat pesan...</div>
                </div>
                <div class="p-4 border-t border-gray-200 bg-white">
                    <form id="sendMessageForm" class="flex space-x-3 items-center">
                        <input type="hidden" name="penerima_id" id="currentPenerimaId">
                        <select name="jenis_id" id="sendJenis" class="w-1/5 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Jenis</option>
                        </select>
                        <input type="text" name="isi" placeholder="Ketik pesan..." class="flex-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-2 outline-none">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Kirim
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="addPesanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-6 border w-11/12 md:w-3/4 lg:w-1/2 shadow-xl rounded-xl bg-white">
            <div class="mt-3">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Kirim Pesan Baru</h3>
                <form id="addPesanForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Penerima</label>
                            <select id="addPenerima" name="penerima_id" required class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Penerima</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Pesan</label>
                            <select id="addJenis" name="jenis_id" required class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
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



    <script src="{{ asset('js/pesan/pesan.js') }}"></script>
    <style>
        #chatMessages .message {
            max-width: 70%;
            margin-bottom: 1.5rem;
            padding: 0.75rem 1.25rem;
            border-radius: 1rem;
            clear: both;
            position: relative;
            transition: all 0.2s ease;
        }
        #chatMessages .message.sent {
            background-color: #DCF8C6;
            margin-left: auto;
            border-top-right-radius: 0;
        }
        #chatMessages .message.received {
            background-color: #FFFFFF;
            margin-right: auto;
            border-top-left-radius: 0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        #chatMessages .message .avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 0.5rem;
        }
        #chatMessages .message.sent .avatar {
            margin-left: 0.5rem;
            margin-right: 0;
        }
        .delete-btn {
            opacity: 0;
            transition: opacity 0.2s;
        }
        .message:hover .delete-btn {
            opacity: 1;
        }
        .conversation-item {
            transition: background-color 0.2s ease;
        }
        .conversation-item:hover {
            background-color: #F9FAFB;
        }
        .chat-container {
            background: linear-gradient(to bottom, #F9FAFB, #E5E7EB);
        }
    </style>
</x-layouts.main>