

let currentPage = 1;
let currentFilters = {};
const ITEMS_PER_PAGE = 10;


const userProfileId = document.querySelector('meta[name="user-profile-id"]')?.getAttribute('content');

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
            let data = result.data.jamKerjasByUserProfile || [];
            data = applyClientSideFilters(data, filters);
            const start = (page - 1) * ITEMS_PER_PAGE;
            const paginatedData = data.slice(start, start + ITEMS_PER_PAGE);
            renderProgressTable(paginatedData);
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
        if (filters.proyek_id && item.proyek?.id !== parseInt(filters.proyek_id)) {
            matches = false;
        }
        if (filters.status_id && item.status?.id !== parseInt(filters.status_id)) {
            matches = false;
        }
        return matches;
    });
}

function buildQuery(page, filters) {
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

function renderProgressTable(data) {
    const tbody = document.getElementById('progressTableBody');
    tbody.innerHTML = data.length ? '' : `
        <tr>
            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                Tidak ada data progress kerja
            </td>
        </tr>
    `;

    data.forEach(item => {
        tbody.innerHTML += `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatDate(item.tanggal)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.proyek?.nama || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.aktivitas?.nama || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.jumlah_jam} jam</td>
                <td class="px-6 py-4 text-sm text-gray-900">${item.keterangan || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getStatusColor(item.status?.id)}">
                        ${item.status?.nama || '-'}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editProgress(${item.id})" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</button>
                    <button onclick="deleteProgress(${item.id})" class="text-red-600 hover:text-red-900">Hapus</button>
                </td>
            </tr>
        `;
    });
}

function updateSummary(data) {
    const totalJam = data.reduce((sum, item) => sum + parseFloat(item.jumlah_jam || 0), 0);
   
    const today = new Date().toISOString().split('T')[0];
    const todayProgress = data.filter(item => {
        const itemDate = new Date(item.tanggal).toISOString().split('T')[0];
        console.log('Item tanggal:', item.tanggal, 'Normalized:', itemDate, 'Today:', today); 
        return itemDate === today;
    }).length;
    const completed = data.filter(item => {
        console.log('Full status structure:', JSON.stringify(item.status));
        console.log('Status item:', item.status); 
        return parseInt(item.status?.id) === 1; 
    }).length;
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

        console.log('Status data:', statusData.data.allStatusJamKerja); 
        console.log('Mode data:', modeData.data.allModeJamKerja); 

        if (proyekData.errors || aktivitasData.errors || statusData.errors || modeData.errors) {
            throw new Error('Gagal memuat data dropdown: ' + [
                ...(proyekData.errors?.map(e => e.message) || []),
                ...(aktivitasData.errors?.map(e => e.message) || []),
                ...(statusData.errors?.map(e => e.message) || []),
                ...(modeData.errors?.map(e => e.message) || [])
            ].join(', '));
        }

        populateDropdown('filterProyek', proyekData.data.allProyeks, 'id', 'nama', 'Semua Proyek');
        populateDropdown('addProyek', proyekData.data.allProyeks, 'id', 'nama', 'Pilih Proyek');
        populateDropdown('editProyek', proyekData.data.allProyeks, 'id', 'nama', 'Pilih Proyek');
        populateDropdown('addAktivitas', aktivitasData.data.allAktivitas, 'id', 'nama', 'Pilih Aktivitas');
        populateDropdown('editAktivitas', aktivitasData.data.allAktivitas, 'id', 'nama', 'Pilih Aktivitas');
        populateDropdown('addStatus', statusData.data.allStatusJamKerja, 'id', 'nama', 'Pilih Status');
        populateDropdown('editStatus', statusData.data.allStatusJamKerja, 'id', 'nama', 'Pilih Status');
        populateDropdown('addMode', modeData.data.allModeJamKerja, 'id', 'nama', 'Pilih Mode');
        populateDropdown('editMode', modeData.data.allModeJamKerja, 'id', 'nama', 'Pilih Mode');
    } catch (error) {
        console.error('Error loading dropdown data:', error);
        showError('Gagal memuat data dropdown: ' + error.message);
    }
}

function populateDropdown(selectId, data, valueKey, textKey, defaultText = 'Pilih') {
    const select = document.getElementById(selectId);
    if (!select) return;

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
    currentFilters = {
        tanggal: document.getElementById('filterTanggal').value,
        proyek_id: document.getElementById('filterProyek').value,
        status_id: document.getElementById('filterStatus').value
    };
    currentPage = 1;
    loadProgresData(currentPage, currentFilters);
}

function updatePagination(total, page) {
    const info = document.getElementById('paginationInfo');
    const links = document.getElementById('paginationLinks');
    const totalPages = Math.ceil(total / ITEMS_PER_PAGE);
    info.textContent = `Menampilkan ${Math.min(total, ITEMS_PER_PAGE)} dari ${total} data (Halaman ${page})`;

    links.innerHTML = `
        <button onclick="changePage(${page - 1})" ${page === 1 ? 'disabled' : ''} class="px-3 py-1 bg-gray-200 rounded ${page === 1 ? 'opacity-50' : 'hover:bg-gray-300'}">Sebelumnya</button>
        <span class="px-3 py-1 bg-blue-500 text-white rounded">Halaman ${page}</span>
        <button onclick="changePage(${page + 1})" ${page >= totalPages ? 'disabled' : ''} class="px-3 py-1 bg-gray-200 rounded ${page >= totalPages ? 'opacity-50' : 'hover:bg-gray-300'}">Berikutnya</button>
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
    loadProgresData();
    loadDropdownData();
});
