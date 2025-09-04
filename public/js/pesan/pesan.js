let currentPenerimaId = null;
const userProfileId = document.querySelector('meta[name="user-profile-id"]')?.getAttribute('content');
const userLevelName = document.querySelector('meta[name="user-level-name"]')?.getAttribute('content') || 'User';

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (!meta) {
        throw new Error('CSRF token not found. Please ensure <meta name="csrf-token"> is included in the HTML.');
    }
    return meta.getAttribute('content');
}

async function loadConversationList() {
    try {
        const query = userLevelName === 'Admin' ? `
            query {
                allPesan {
                    id
                    penerima { id nama_lengkap foto }
                    pengirim { id nama_lengkap foto }
                }
            }
        ` : `
            query {
                pesansByUserProfile(user_profile_id: ${parseInt(userProfileId)}) {
                    id
                    penerima { id nama_lengkap foto }
                    pengirim { id nama_lengkap foto }
                }
            }
        `;
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query })
        });
        const result = await response.json();
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        const data = userLevelName === 'Admin' ? result.data.allPesan : result.data.pesansByUserProfile;
        
        const uniqueConversations = [];
        const seenPairs = new Set();
        
        data.forEach(item => {
            if (!item.penerima || !item.pengirim) return;
            
            if (String(item.penerima.id) === String(item.pengirim.id)) return;
            
            let otherUser;
            if (String(item.pengirim.id) === String(userProfileId)) {
                otherUser = item.penerima;
            } else if (String(item.penerima.id) === String(userProfileId)) {
                otherUser = item.pengirim;
            } else {
                return; 
            }
            
            const key = String(otherUser.id);
            if (!seenPairs.has(key)) {
                seenPairs.add(key);
                uniqueConversations.push(otherUser);
            }
        });
        
        renderConversationList(uniqueConversations);
    } catch (error) {
        console.error('Error loading conversation list:', error);
        showError('Gagal memuat daftar percakapan: ' + error.message);
    }
}

function renderConversationList(penerimaList) {
    const conversationList = document.getElementById('conversationList');
    conversationList.innerHTML = penerimaList.length ? '' : `
        <div class="p-4 text-center text-gray-500">Tidak ada percakapan</div>
    `;
    penerimaList.forEach(penerima => {
        const isActive = String(penerima.id) === String(currentPenerimaId);
        const activeClass = isActive ? 'active' : '';
        const avatar = penerima.foto ? `<img src="${penerima.foto}" alt="${penerima.nama_lengkap}" class="w-10 h-10 rounded-full object-cover mr-3">` :
            `<div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center mr-3">${penerima.nama_lengkap.charAt(0).toUpperCase()}</div>`;
        conversationList.innerHTML += `
            <div class="conversation-item p-4 cursor-pointer flex items-center ${activeClass}" onclick="selectConversation('${penerima.id}', '${penerima.nama_lengkap.replace(/'/g, "\\'")}', '${penerima.foto || ''}')">
                ${avatar}
                <div>
                    <div class="font-semibold text-gray-800">${penerima.nama_lengkap}</div>
                </div>
            </div>
        `;
    });
}

async function selectConversation(penerimaId, namaLengkap, foto) {
    currentPenerimaId = penerimaId;
    const avatar = foto ? `<img src="${foto}" alt="${namaLengkap}" class="w-10 h-10 rounded-full object-cover mr-3">` :
        `<div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center mr-3">${namaLengkap.charAt(0).toUpperCase()}</div>`;

    const toggleButton = window.innerWidth < 768 ? `
        <button onclick="toggleSidebar()" class="md:hidden mr-3 p-2 rounded-full hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    ` : '';

    document.getElementById('chatHeader').innerHTML = `
        ${toggleButton}
        ${avatar}
        <h2 class="text-lg font-semibold text-gray-800">${namaLengkap}</h2>
    `;
    document.getElementById('currentPenerimaId').value = penerimaId;
    document.getElementById('chatMessages').innerHTML = '';
    const loadingIndicator = document.getElementById('loadingIndicator');
    if (loadingIndicator) {
        loadingIndicator.classList.remove('hidden');
    }
    await loadMessages();
    if (loadingIndicator) {
        loadingIndicator.classList.add('hidden');
    }

    if (window.innerWidth < 768) {
        closeSidebar();
    }

    await loadConversationList();
}

async function loadMessages() {
    try {
        const query = userLevelName === 'Admin' ? `
            query {
                allPesan {
                    id
                    pengirim { id nama_lengkap foto }
                    penerima { id nama_lengkap foto }
                    isi
                    tgl_pesan
                    jenis { id nama }
                    created_at
                }
            }
        ` : `
            query {
                pesansByUserProfile(user_profile_id: ${parseInt(userProfileId)}) {
                    id
                    pengirim { id nama_lengkap foto }
                    penerima { id nama_lengkap foto }
                    isi
                    tgl_pesan
                    jenis { id nama }
                    created_at
                }
            }
        `;
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query })
        });
        const result = await response.json();
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        const data = userLevelName === 'Admin' ? result.data.allPesan : result.data.pesansByUserProfile;
        
        console.log('Messages data:', data);
        
        const filteredData = data.filter(item => {
            if (!item.penerima || !item.pengirim) return false;
            console.log(`Message ID: ${item.id}, Pengirim ID: ${item.pengirim.id}, Penerima ID: ${item.penerima.id}`);
            return (
                (String(item.penerima.id) === String(currentPenerimaId) && String(item.pengirim.id) === String(userProfileId)) ||
                (String(item.pengirim.id) === String(currentPenerimaId) && String(item.penerima.id) === String(userProfileId))
            );
        });
        
        const validMessages = filteredData.filter(item => 
            String(item.penerima?.id) !== String(item.pengirim?.id)
        );
        
        renderMessages(validMessages);
    } catch (error) {
        console.error('Error loading messages:', error);
        showError('Gagal memuat pesan: ' + error.message);
    }
}

function renderMessages(messages) {
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.innerHTML = messages.length ? '' : `
        <div class="text-center text-gray-500 p-4">Tidak ada pesan</div>
    `;
    messages.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
    messages.forEach(message => {
        const isSent = String(message.pengirim?.id) === String(userProfileId);
        console.log(`Rendering message ID: ${message.id}, isSent: ${isSent}, Pengirim: ${message.pengirim?.nama_lengkap} (${message.pengirim?.foto}), Penerima: ${message.penerima?.nama_lengkap} (${message.penerima?.foto})`);
        const avatar = isSent ? 
            (message.pengirim?.foto ? 
                `<img src="${message.pengirim.foto}" alt="${message.pengirim.nama_lengkap}" class="avatar">` : 
                `<div class="avatar bg-blue-500 text-white flex items-center justify-center">${message.pengirim?.nama_lengkap?.charAt(0).toUpperCase() || '-'}</div>`) :
            (message.penerima?.foto ? 
                `<img src="${message.penerima.foto}" alt="${message.penerima.nama_lengkap}" class="avatar">` : 
                `<div class="avatar bg-gray-500 text-white flex items-center justify-center">${message.penerima?.nama_lengkap?.charAt(0).toUpperCase() || '-'}</div>`);
        const deleteButton = isSent ? `
            <button onclick="deleteMessage(${message.id})" 
                    class="delete-btn ml-2 text-red-500 hover:text-red-700 text-xs"
                    title="Hapus pesan">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        ` : '';
        chatMessages.innerHTML += `
            <div class="message ${isSent ? 'sent' : 'received'}" data-message-id="${message.id}">
                <div class="flex ${isSent ? 'flex-row-reverse' : 'flex-row'} items-start">
                   
                    <div class="flex-1">
                        <div class="text-sm">${message.isi || '-'}</div>
                        <div class="text-xs text-gray-500 mt-1">${formatDate(message.created_at)}</div>
                    </div>
                    ${deleteButton}
                </div>
            </div>
        `;
    });
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

async function loadDropdownData() {
    try {
        const jenisQuery = `query { allJenisPesan { id nama deleted_at } }`;
        const userQuery = `query { allUserProfiles { id nama_lengkap foto } }`;
        const [jenisResponse, userResponse] = await Promise.all([
            fetch('/graphql', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                body: JSON.stringify({ query: jenisQuery })
            }),
            fetch('/graphql', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                body: JSON.stringify({ query: userQuery })
            })
        ]);
        const jenisData = await jenisResponse.json();
        const userData = await userResponse.json();
        if (jenisData.errors || userData.errors) {
            throw new Error('Gagal memuat data dropdown: ' + [
                ...(jenisData.errors?.map(e => e.message) || []),
                ...(userData.errors?.map(e => e.message) || [])
            ].join(', '));
        }

        const activeJenis = jenisData.data.allJenisPesan.filter(jenis => !jenis.deleted_at);
        populateDropdown('addJenis', activeJenis, 'id', 'nama', 'Pilih Jenis');
        populateDropdown('sendJenis', activeJenis, 'id', 'nama', 'Pilih Jenis');
        renderUserDropdown(userData.data.allUserProfiles.filter(user => user.id !== userProfileId));
    } catch (error) {
        console.error('Error loading dropdown data:', error);
        showError('Gagal memuat data dropdown: ' + error.message);
    }
}

function populateDropdown(selectId, data, valueKey, textKey, defaultText = 'Pilih') {
    const select = document.getElementById(selectId);
    if (!select) {
        console.error(`Dropdown with ID ${selectId} not found`);
        return;
    }
    select.innerHTML = `<option value="">${defaultText}</option>`;
    data.forEach(item => {
        const option = document.createElement('option');
        option.value = item[valueKey];
        option.textContent = item[textKey];
        select.appendChild(option);
    });
}

function renderUserDropdown(users) {
    const container = document.getElementById('addPenerimaList');
    if (!container) {
        console.error('User dropdown container not found');
        return;
    }
    container.innerHTML = users.length ? '' : '<div class="px-3 py-2 text-gray-500 text-sm">Tidak ada pengguna tersedia</div>';

    users.forEach(user => {
        const avatar = user.foto ?
            `<img src="${user.foto}" alt="${user.nama_lengkap}" class="w-8 h-8 rounded-full object-cover mr-3">` :
            `<div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center mr-3 font-semibold text-sm">${user.nama_lengkap.charAt(0).toUpperCase()}</div>`;

        const option = document.createElement('div');
        option.className = 'dropdown-option px-3 py-2 hover:bg-gray-100 cursor-pointer flex items-center';
        option.setAttribute('data-user-id', user.id);
        option.innerHTML = `
            ${avatar}
            <div class="flex-1 min-w-0">
                <div class="font-medium text-gray-900 truncate text-sm">${user.nama_lengkap}</div>
            </div>
        `;
        option.onclick = () => selectUserFromDropdown(user.id, user.nama_lengkap, user.foto);
        container.appendChild(option);
    });
}

function selectUserFromDropdown(userId, namaLengkap, foto) {
    const selectedSpan = document.getElementById('addPenerimaSelected');
    const avatar = foto ?
        `<img src="${foto}" alt="${namaLengkap}" class="w-6 h-6 rounded-full object-cover mr-2">` :
        `<div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center mr-2 font-semibold text-xs">${namaLengkap.charAt(0).toUpperCase()}</div>`;

    selectedSpan.innerHTML = `${avatar}<span class="truncate">${namaLengkap}</span>`;
    selectedSpan.className = 'text-gray-900 flex items-center';

    document.getElementById('addPenerima').value = userId;
    toggleDropdown(false);
}

function toggleDropdown(show = null) {
    const options = document.getElementById('addPenerimaOptions');
    const arrow = document.getElementById('addPenerimaArrow');

    if (show === null) {
        show = options.classList.contains('hidden');
    }

    if (show) {
        options.classList.remove('hidden');
        arrow.classList.add('rotate-180');
    } else {
        options.classList.add('hidden');
        arrow.classList.remove('rotate-180');
    }
}

function initDropdown() {
    const dropdown = document.getElementById('addPenerimaDropdown');
    if (dropdown) {
        dropdown.onclick = () => toggleDropdown();
    }

    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('addPenerimaDropdown');
        const options = document.getElementById('addPenerimaOptions');
        if (!dropdown.contains(e.target) && !options.contains(e.target)) {
            toggleDropdown(false);
        }
    });
}

function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId, formId) {
    document.getElementById(modalId).classList.add('hidden');
    if (formId) {
        document.getElementById(formId).reset();
        const selectedSpan = document.getElementById('addPenerimaSelected');
        if (selectedSpan) {
            selectedSpan.innerHTML = 'Pilih Penerima';
            selectedSpan.className = 'text-gray-500';
        }
        document.getElementById('addPenerima').value = '';
        toggleDropdown(false);
    }
}

async function deleteMessage(messageId) {
    if (!confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
        return;
    }

    try {
        const mutation = `
            mutation {
                deletePesan(id: ${messageId}) {
                    id
                    isi
                }
            }
        `;
        
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query: mutation })
        });
        
        const result = await response.json();
        
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }
        
        const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
        if (messageElement) {
            messageElement.style.opacity = '0.5';
            messageElement.style.transition = 'opacity 0.3s';
            setTimeout(() => {
                messageElement.remove();
            }, 300);
        }
        
        await loadMessages();
        
    } catch (error) {
        console.error('Error deleting message:', error);
        showError('Gagal menghapus pesan: ' + error.message);
    }
}

async function sendMessage(formId, penerimaId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    const input = Object.fromEntries(formData);

    const validationError = validateFormData(input);
    if (validationError) {
        showError(validationError);
        return;
    }

    const mutation = `
        mutation {
            createPesan(input: {
                pengirim_id: ${parseInt(userProfileId)}
                penerima_id: ${parseInt(penerimaId || input.penerima_id)}
                isi: "${input.isi.replace(/"/g, '\\"')}"
                jenis_id: ${parseInt(input.jenis_id)}
                tgl_pesan: "${new Date().toISOString()}"
            }) {
                id
                tgl_pesan
                penerima { id nama_lengkap foto }
            }
        }
    `;
    try {
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query: mutation })
        });
        const result = await response.json();
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }
        if (result.data) {
            closeModal('addPesanModal', 'addPesanForm');
            await loadConversationList();
            const penerima = result.data.createPesan.penerima;
            if (penerimaId || input.penerima_id === currentPenerimaId) {
                await loadMessages();
            } else {
                selectConversation(penerima.id, penerima.nama_lengkap.replace(/'/g, "\\'"), penerima.foto || '');
            }
        }
    } catch (error) {
        console.error('Error sending message:', error);
        showError('Gagal mengirim pesan: ' + error.message);
    }
}

function validateFormData(input) {
    if (!input.penerima_id && !currentPenerimaId) return 'Penerima harus dipilih';
    if (!input.isi) return 'Isi pesan harus diisi';
    if (!input.jenis_id) return 'Jenis pesan harus dipilih';
    if (!userProfileId || isNaN(parseInt(userProfileId))) return 'User profile ID tidak valid';
    return null;
}

function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md';
    errorDiv.innerHTML = `<span>${message}</span><button onclick="this.parentElement.remove()" class="ml-4 text-red-700 font-bold">x</button>`;
    document.body.appendChild(errorDiv);
    setTimeout(() => errorDiv.remove(), 5000);
}

document.getElementById('addPesanForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    await sendMessage('addPesanForm');
});

document.getElementById('sendMessageForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!currentPenerimaId) {
        showError('Pilih penerima dari daftar percakapan');
        return;
    }
    await sendMessage('sendMessageForm', currentPenerimaId);
});

document.addEventListener('DOMContentLoaded', () => {
    if (!userProfileId || isNaN(parseInt(userProfileId))) {
        showError('User profile ID tidak valid. Silakan login ulang.');
        return;
    }
    if (!['Admin', 'User'].includes(userLevelName)) {
        showError('Level pengguna tidak valid. Harus admin (4) atau user (7).');
        return;
    }
    loadConversationList();
    loadDropdownData();
    initDropdown();

    window.toggleSidebar = function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    };

    window.closeSidebar = function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    };
});
