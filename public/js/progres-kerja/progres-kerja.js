let currentPage = 1;
let currentFilters = {};
const ITEMS_PER_PAGE = 10;

const userProfileId = document.querySelector('meta[name="user-profile-id"]')?.getAttribute('content');
const userLevelName = document.querySelector('meta[name="user-level-name"]')?.getAttribute('content') || 'User';

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (!meta) {
        throw new Error('CSRF token not found. Please ensure <meta name="csrf-token"> is included in the HTML.');
    }
    return meta.getAttribute('content');
}

async function loadProgresData(page = 1, filters = {}) {
    try {
        const query = buildQuery(page, filters);
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query })
        });

        const result = await response.json();
        console.log('GraphQL response (loadProgresData):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        if (result.data) {
            let data = userLevelName === 'Admin' ? result.data.allJamKerja || [] : result.data.jamKerjasByUserProfile || [];
            data = applyClientSideFilters(data, filters);
            const start = (page - 1) * ITEMS_PER_PAGE;
            const paginatedData = data.slice(start, start + ITEMS_PER_PAGE);
            renderProgressCards(paginatedData);
            updateSummary(data);
            updatePagination(data.length, page);
        }
    } catch (error) {
        console.error('Error loading progress data:', error);
        showError('Gagal memuat data progress kerja: ' + error.message);
    }
}

function applyClientSideFilters(data, filters) {
    return data.filter(item => {
        let matches = true;
        if (filters.tanggal && item.tanggal !== filters.tanggal) {
            matches = false;
        }
        if (filters.proyek_id && parseInt(filters.proyek_id) !== (item.proyek?.id ? parseInt(item.proyek.id) : null)) {
            matches = false;
        }
        if (filters.status_id && parseInt(filters.status_id) !== (item.status?.id ? parseInt(item.status.id) : null)) {
            matches = false;
        }
        return matches;
    });
}

function buildQuery(page, filters) {
    if (userLevelName === 'Admin') {
        return `
            query {
                allJamKerja {
                    id
                    tanggal
                    jumlah_jam
                    keterangan
                    proyek {
                        id
                        nama
                        kode
                    }
                    aktivitas {
                        id
                        nama
                    }
                    status {
                        id
                        nama
                    }
                    mode {
                        id
                        nama
                    }
                    userprofile {
                        id
                        nama_lengkap
                    }
                    created_at
                    updated_at
                }
            }
        `;
    } else {
        return `
            query {
                jamKerjasByUserProfile(user_profile_id: ${parseInt(userProfileId)}) {
                    id
                    tanggal
                    jumlah_jam
                    keterangan
                    proyek {
                        id
                        nama
                        kode
                    }
                    aktivitas {
                        id
                        nama
                    }
                    status {
                        id
                        nama
                    }
                    mode {
                        id
                        nama
                    }
                    userprofile {
                        id
                        nama_lengkap
                    }
                    created_at
                    updated_at
                }
            }
        `;
    }
}

function renderProgressCards(data) {
    const container = document.getElementById('progressCardsContainer');
    const isAdmin = userLevelName === 'Admin';
    container.innerHTML = data.length ? '' : `
        <div class="col-span-full text-center py-8">
            <div class="text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data progress kerja</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada progress kerja yang tersedia.</p>
            </div>
        </div>
    `;

    data.forEach(item => {
        const card = document.createElement('div');
        card.className = 'bg-white rounded-lg shadow-md p-4 border border-gray-200 hover:shadow-lg transition-all duration-200 cursor-pointer flex flex-row items-center space-x-4 relative group';
        card.style.minHeight = '100px';
        card.onclick = () => editProgress(item.id);
        card.innerHTML = `
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">${item.proyek?.nama || '-'}</h3>
                <p class="text-sm text-gray-600">${formatDate(item.tanggal)}</p>
                ${isAdmin ? `<p class="text-sm text-gray-700"><strong>User:</strong> ${item.userprofile?.nama_lengkap || '-'}</p>` : ''}
                <p class="text-sm text-gray-700"><strong>Aktivitas:</strong> ${item.aktivitas?.nama || '-'}</p>
                <p class="text-sm text-gray-700"><strong>Jam Kerja:</strong> ${item.jumlah_jam} jam</p>
                ${item.keterangan ? `<p class="text-sm text-gray-700"><strong>Keterangan:</strong> ${item.keterangan}</p>` : ''}
            </div>
            <div class="flex flex-col justify-between items-end space-y-2 min-w-[120px]">
                <span class="px-2 py-1 text-xs font-semibold rounded-full ${getStatusColor(item.status?.id)}">
                    ${item.status?.nama || '-'}
                </span>
                <button onclick="event.stopPropagation(); deleteProgress(${item.id})" class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 p-1 hover:bg-red-50 rounded-full" title="Hapus">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        `;
        container.appendChild(card);
    });
}

function updateSummary(data) {
    const totalJam = data.reduce((sum, item) => sum + parseFloat(item.jumlah_jam || 0), 0);
    const today = new Date().toISOString().split('T')[0];
    const todayProgress = data.filter(item => {
        const itemDate = new Date(item.tanggal).toISOString().split('T')[0];
        return itemDate === today;
    }).length;
    const completed = data.filter(item => parseInt(item.status?.id) === 1).length;
    const percentage = data.length > 0 ? Math.round((completed / data.length) * 100) : 0;

    console.log('Total entries:', data.length, 'Completed:', completed, 'Percentage:', percentage);

    document.getElementById('totalJam').textContent = totalJam.toFixed(1);
    document.getElementById('proyekAktif').textContent = new Set(data.map(item => item.proyek?.id).filter(Boolean)).size;
    document.getElementById('progressHariIni').textContent = todayProgress;
    document.getElementById('persentaseSelesai').textContent = percentage + '%';
}

function getStatusColor(statusId) {
    const colors = {
        1: 'bg-green-100 text-green-800',
        2: 'bg-red-100 text-red-800',
        3: 'bg-yellow-100 text-yellow-800',
        4: 'bg-green-100 text-green-800',
        5: 'bg-red-100 text-red-800'
    };
    return colors[statusId] || 'bg-gray-100 text-gray-800';
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

async function loadDropdownData() {
    try {
        const proyekQuery = `query { allProyeks { id nama kode } }`;
        const aktivitasQuery = `query { allAktivitas { id nama } }`;
        const statusQuery = `query { allStatusJamKerja { id nama deleted_at } }`;
        const modeQuery = `query { allModeJamKerja { id nama deleted_at } }`;

        const [proyekResponse, aktivitasResponse, statusResponse, modeResponse] = await Promise.all([
            fetch('/graphql', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() }, body: JSON.stringify({ query: proyekQuery }) }),
            fetch('/graphql', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() }, body: JSON.stringify({ query: aktivitasQuery }) }),
            fetch('/graphql', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() }, body: JSON.stringify({ query: statusQuery }) }),
            fetch('/graphql', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() }, body: JSON.stringify({ query: modeQuery }) })
        ]);

        const proyekData = await proyekResponse.json();
        const aktivitasData = await aktivitasResponse.json();
        const statusData = await statusResponse.json();
        const modeData = await modeResponse.json();

        console.log('Proyek data:', proyekData.data?.allProyeks);
        console.log('Aktivitas data:', aktivitasData.data?.allAktivitas);
        console.log('Status data:', statusData.data?.allStatusJamKerja);
        console.log('Mode data:', modeData.data?.allModeJamKerja);

        if (proyekData.errors || aktivitasData.errors || statusData.errors || modeData.errors) {
            throw new Error('Gagal memuat data dropdown: ' + [
                ...(proyekData.errors?.map(e => e.message) || []),
                ...(aktivitasData.errors?.map(e => e.message) || []),
                ...(statusData.errors?.map(e => e.message) || []),
                ...(modeData.errors?.map(e => e.message) || [])
            ].join(', '));
        }

        const activeStatuses = statusData.data.allStatusJamKerja.filter(status => !status.deleted_at);
        const activeModes = modeData.data.allModeJamKerja.filter(mode => !mode.deleted_at);

        populateDropdown('filterProyek', proyekData.data.allProyeks, 'id', 'nama', 'Semua Proyek');
        populateDropdown('addProyek', proyekData.data.allProyeks, 'id', 'nama', 'Pilih Proyek');
        populateDropdown('editProyek', proyekData.data.allProyeks, 'id', 'nama', 'Pilih Proyek');
        populateDropdown('addAktivitas', aktivitasData.data.allAktivitas, 'id', 'nama', 'Pilih Aktivitas');
        populateDropdown('editAktivitas', aktivitasData.data.allAktivitas, 'id', 'nama', 'Pilih Aktivitas');
        populateDropdown('filterStatus', activeStatuses, 'id', 'nama', 'Semua Status');
        populateDropdown('addStatus', activeStatuses, 'id', 'nama', 'Pilih Status');
        populateDropdown('editStatus', activeStatuses, 'id', 'nama', 'Pilih Status');
        populateDropdown('addMode', activeModes, 'id', 'nama', 'Pilih Mode');
        populateDropdown('editMode', activeModes, 'id', 'nama', 'Pilih Mode');
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

function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId, formId) {
    document.getElementById(modalId).classList.add('hidden');
    if (formId) document.getElementById(formId).reset();
}

async function editProgress(id) {
    try {
        const query = `
            query {
                jamKerja(id: ${id}) {
                    id
                    tanggal
                    jumlah_jam
                    keterangan
                    proyek { id nama }
                    aktivitas { id nama }
                    status { id nama }
                    mode { id nama }
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
        console.log('GraphQL response (editProgress):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        const data = result.data.jamKerja;
        if (data) {
            const form = document.getElementById('editProgressForm');
            form.querySelector('input[name="id"]').value = data.id;
            form.querySelector('input[name="tanggal"]').value = data.tanggal;
            form.querySelector('input[name="jumlah_jam"]').value = data.jumlah_jam;
            form.querySelector('textarea[name="keterangan"]').value = data.keterangan || '';
            form.querySelector('select[name="proyek_id"]').value = data.proyek?.id || '';
            form.querySelector('select[name="aktivitas_id"]').value = data.aktivitas?.id || '';
            form.querySelector('select[name="status_id"]').value = data.status?.id || '';
            form.querySelector('select[name="mode_id"]').value = data.mode?.id || '';
            openModal('editProgressModal');
        }
    } catch (error) {
        console.error('Error loading progress for edit:', error);
        showError('Gagal memuat data untuk edit: ' + error.message);
    }
}

async function deleteProgress(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus progress ini?')) return;

    try {
        const mutation = `mutation { deleteJamKerja(id: ${id}) { id } }`;
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query: mutation })
        });

        const result = await response.json();
        console.log('GraphQL response (deleteProgress):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        if (result.data) {
            loadProgresData(currentPage, currentFilters);
        }
    } catch (error) {
        console.error('Error deleting progress:', error);
        showError('Gagal menghapus progress: ' + error.message);
    }
}

function filterProgress() {
    const proyekId = document.getElementById('filterProyek').value;
    const statusId = document.getElementById('filterStatus').value;
    currentFilters = {
        tanggal: document.getElementById('filterTanggal').value,
        proyek_id: proyekId ? parseInt(proyekId) : null,
        status_id: statusId ? parseInt(statusId) : null
    };
    console.log('Applying filters:', currentFilters);
    currentPage = 1;
    loadProgresData(currentPage, currentFilters);
}

function updatePagination(total, page) {
    const info = document.getElementById('paginationInfo');
    const links = document.getElementById('paginationLinks');
    const totalPages = Math.ceil(total / ITEMS_PER_PAGE);
    info.textContent = `Menampilkan ${Math.min(total, ITEMS_PER_PAGE)} dari ${total} data (Halaman ${page})`;

    const prevDisabled = page === 1 ? 'disabled opacity-50 cursor-not-allowed' : 'hover:bg-gray-300';
    const nextDisabled = page >= totalPages ? 'disabled opacity-50 cursor-not-allowed' : 'hover:bg-gray-300';

    links.innerHTML = `
        <button onclick="changePage(${page - 1})" ${page === 1 ? 'disabled' : ''} class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-gray-200 rounded-full transition-colors ${prevDisabled}" title="Halaman Sebelumnya">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <span class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 text-white rounded-full text-xs sm:text-sm font-medium">${page}</span>
        <button onclick="changePage(${page + 1})" ${page >= totalPages ? 'disabled' : ''} class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-gray-200 rounded-full transition-colors ${nextDisabled}" title="Halaman Berikutnya">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    `;
}

function changePage(page) {
    if (page < 1) return;
    currentPage = page;
    loadProgresData(currentPage, currentFilters);
}

function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
    errorDiv.innerHTML = `<span>${message}</span><button onclick="this.parentElement.remove()" class="ml-4 text-red-700">x</button>`;
    document.body.appendChild(errorDiv);
    setTimeout(() => errorDiv.remove(), 5000);
}

function validateFormData(input) {
    if (!input.proyek_id) return 'Proyek harus dipilih';
    if (!input.aktivitas_id) return 'Aktivitas harus dipilih';
    if (!input.tanggal) return 'Tanggal harus diisi';
    if (!input.jumlah_jam || parseFloat(input.jumlah_jam) <= 0) return 'Jam kerja harus lebih dari 0';
    if (!input.status_id) return 'Status harus dipilih';
    if (!input.mode_id) return 'Mode harus dipilih';
    if (!userProfileId || isNaN(parseInt(userProfileId))) return 'User profile ID tidak valid. Periksa konfigurasi autentikasi.';
    return null;
}

document.getElementById('addProgressForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const input = Object.fromEntries(formData);

    const validationError = validateFormData(input);
    if (validationError) {
        showError(validationError);
        return;
    }

    const mutation = `
        mutation {
            createJamKerja(input: {
                proyek_id: ${parseInt(input.proyek_id)}
                user_profile_id: ${parseInt(userProfileId)}
                aktivitas_id: ${parseInt(input.aktivitas_id)}
                tanggal: "${input.tanggal}"
                jumlah_jam: ${parseFloat(input.jumlah_jam)}
                keterangan: "${input.keterangan || ''}"
                status_id: ${parseInt(input.status_id)}
                mode_id: ${parseInt(input.mode_id)}
            }) {
                id
                tanggal
            }
        }
    `;

    try {
        console.log('Sending mutation (createJamKerja):', mutation);
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query: mutation })
        });

        const result = await response.json();
        console.log('GraphQL response (createJamKerja):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        if (result.data) {
            closeModal('addProgressModal', 'addProgressForm');
            loadProgresData(currentPage, currentFilters);
        }
    } catch (error) {
        console.error('Error creating progress:', error);
        showError('Gagal menambahkan progress: ' + error.message);
    }
});

document.getElementById('editProgressForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const input = Object.fromEntries(formData);

    const validationError = validateFormData(input);
    if (validationError) {
        showError(validationError);
        return;
    }

    const mutation = `
        mutation {
            updateJamKerja(id: ${input.id}, input: {
                proyek_id: ${parseInt(input.proyek_id)}
                user_profile_id: ${parseInt(userProfileId)}
                aktivitas_id: ${parseInt(input.aktivitas_id)}
                tanggal: "${input.tanggal}"
                jumlah_jam: ${parseFloat(input.jumlah_jam)}
                keterangan: "${input.keterangan || ''}"
                status_id: ${parseInt(input.status_id)}
                mode_id: ${parseInt(input.mode_id)}
            }) {
                id
                tanggal
            }
        }
    `;

    try {
        console.log('Sending mutation (updateJamKerja):', mutation);
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query: mutation })
        });

        const result = await response.json();
        console.log('GraphQL response (updateJamKerja):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        if (result.data) {
            closeModal('editProgressModal', 'editProgressForm');
            loadProgresData(currentPage, currentFilters);
        }
    } catch (error) {
        console.error('Error updating progress:', error);
        showError('Gagal memperbarui progress: ' + error.message);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    if (!userProfileId || isNaN(parseInt(userProfileId))) {
        showError('User profile ID tidak valid. Silakan login ulang atau periksa konfigurasi.');
        return;
    }
    if (!['Admin', 'User'].includes(userLevelName)) {
        showError('Level pengguna tidak valid. Harus admin (4) atau user (7).');
        return;
    }
    loadProgresData();
    loadDropdownData();
});