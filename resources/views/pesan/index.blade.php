<x-layouts.main title="Pesan">
    <div class="container mx-auto h-screen flex flex-col bg-gray-50">
        <div class="flex flex-1 overflow-hidden relative">
            <div id="sidebar" class="fixed inset-y-0 left-0 z-30 w-80 bg-white shadow-lg border-r border-gray-200 transform -translate-x-full md:translate-x-0 md:static md:inset-0 md:w-1/3 transition-transform duration-300 ease-in-out">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4 text-white sticky top-0 z-10">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-2xl font-bold">Pesan</h1>
                        <button onclick="closeSidebar()" class="md:hidden text-white hover:bg-blue-700 p-2 rounded-full transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center space-x-3 mb-4 p-3 bg-white bg-opacity-10 rounded-lg">
                        @if(auth()->user()->userprofile->foto)
                            <img src="{{ asset(auth()->user()->userprofile->foto) }}" alt="{{ auth()->user()->userprofile->nama_lengkap }}" class="w-16 h-16 rounded-full object-cover border-2 border-white">
                        @else
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center border-2 border-white">
                                <span class="text-white font-semibold text-lg">{{ substr(auth()->user()->userprofile->nama_lengkap, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-medium text-sm truncate">{{ auth()->user()->userprofile->nama_lengkap }}</p>
                            <p class="text-blue-100 text-xs">{{ auth()->user()->level->nama }}</p>
                        </div>
                    </div>

                    <button onclick="openModal('addPesanModal')" class="bg-white text-blue-600 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-100 transition-colors w-full md:w-auto">
                        Pesan Baru
                    </button>
                </div>
                <div id="conversationList" class="divide-y divide-gray-100">
                </div>
            </div>

            <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden hidden" onclick="closeSidebar()"></div>

            <div class="flex-1 flex flex-col bg-white md:w-2/3">
                <div id="chatHeader" class="bg-white p-4 border-b border-gray-200 flex items-center shadow-sm">
                    <button onclick="toggleSidebar()" class="md:hidden mr-3 p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-800">Pilih Penerima untuk Memulai</h2>
                </div>
                <div id="chatMessages" class="flex-1 p-4 overflow-y-auto relative bg-gray-50">
                    <div id="loadingIndicator" class="hidden text-center text-gray-500 p-4">Memuat pesan...</div>
                </div>
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
                            <div class="relative mt-1">
                                <div id="addPenerimaDropdown" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 cursor-pointer bg-white flex items-center justify-between">
                                    <span id="addPenerimaSelected" class="text-gray-500">Pilih Penerima</span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" id="addPenerimaArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                                <div id="addPenerimaOptions" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                    <div id="addPenerimaList" class="py-1"></div>
                                </div>
                            </div>
                            <input type="hidden" id="addPenerima" name="penerima_id" required>
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

    <style>
        #addPenerimaCards .user-card {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 0.5rem;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: border-color 0.3s ease;
        }
        #addPenerimaCards .user-card:hover {
            border-color: #3b82f6; /* blue-500 */
            background-color: #eff6ff; /* blue-100 */
        }
        #addPenerimaCards .user-card.selected {
            border-color: #2563eb; /* blue-600 */
            background-color: #dbeafe; /* blue-200 */
        }
        #addPenerimaCards .user-card img {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            object-fit: cover;
        }
        #addPenerimaCards .user-card .initials {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            background-color: #3b82f6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
        }
    </style>



    <script src="{{ asset('js/pesan/pesan.js') }}"></script>
    <style>
        #chatMessages .message {
            max-width: 75%;
            margin-bottom: 1rem;
            padding: 0.875rem 1rem;
            border-radius: 1.125rem;
            clear: both;
            position: relative;
            transition: all 0.2s ease;
            word-wrap: break-word;
            line-height: 1.4;
        }

        #chatMessages .message.sent {
            background: linear-gradient(135deg, #a4f0e6 0%, #5eaddb 100%);
            color: #374151;
            margin-left: auto;
            margin-right: 0.5rem;
            border-bottom-right-radius: 0.25rem;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        #chatMessages .message.received {
            background-color: #ffffff;
            color: #374151;
            margin-left: 0.5rem;
            margin-right: auto;
            border-bottom-left-radius: 0.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb
        }

        #chatMessages .message .avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 0.75rem;
            border: 2px solid #e5e7eb;
        }

        #chatMessages .message.sent .avatar {
            margin-left: 0.75rem;
            margin-right: 0;
        }

        .delete-btn {
            opacity: 0;
            transition: opacity 0.2s ease;
            background: rgba(239, 68, 68, 0.9);
            border-radius: 50%;
            padding: 0.25rem;
        }

        .message:hover .delete-btn {
            opacity: 1;
        }

        .conversation-item {
            transition: all 0.2s ease;
            padding: 1rem;
            cursor: pointer;
        }

        .conversation-item:hover {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            transform: translateX(2px);
        }

        .conversation-item.active {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 4px solid #3b82f6;
        }

        #chatMessages {
            background: linear-gradient(180deg, #f9fafb 0%, #f3f4f6 100%);
        }

        .message .timestamp {
            font-size: 0.75rem;
            opacity: 0.7;
            margin-top: 0.25rem;
        }

        .message.sent .timestamp {
            text-align: right;
        }

        @media (max-width: 768px) {
            #chatMessages .message {
                max-width: 85%;
                padding: 1rem;
            }

            .conversation-item {
                padding: 1.25rem 1rem;
            }

            .delete-btn {
                opacity: 0;
            }

            .message:hover .delete-btn,
            .message:active .delete-btn {
                opacity: 1;
            }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .loading-dots {
            display: inline-block;
        }

        .loading-dots::after {
            content: '...';
            animation: pulse 1.5s infinite;
        }

        #chatMessages::-webkit-scrollbar,
        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #chatMessages::-webkit-scrollbar-track,
        #sidebar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #chatMessages::-webkit-scrollbar-thumb,
        #sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        #chatMessages::-webkit-scrollbar-thumb:hover,
        #sidebar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</x-layouts.main>