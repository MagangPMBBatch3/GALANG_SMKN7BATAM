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

async function loadLemburData(page = 1, filters = {}) {
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
        console.log('GraphQL response (loadLemburData):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        if (result.data) {
            let data = userLevelName === 'Admin' ? result.data.allLembur || [] : result.data.lembursByUserProfile || [];
            data = applyClientSideFilters(data, filters);
            const start = (page - 1) * ITEMS_PER_PAGE;
            const paginatedData = data.slice(start, start + ITEMS_PER_PAGE);
            renderLemburTable(paginatedData);
            updateSummary(data);
            updatePagination(data.length, page);
        }
    } catch (error) {
        console.error('Error loading lembur data:', error);
        showError('Gagal memuat data lembur: ' + error.message);
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
        return matches;
    });
}

function buildQuery(page, filters) {
    if (userLevelName === 'Admin') {
        return `
            query {
                allLembur {
                    id
                    tanggal
                    proyek {
                        id
                        nama
                        kode
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
                lembursByUserProfile(user_profile_id: ${parseInt(userProfileId)}) {
                    id
                    tanggal
                    proyek {
                        id
                        nama
                        kode
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

function renderLemburTable(data) {
    const tbody = document.getElementById('lemburTableBody');
    tbody.innerHTML = data.length ? '' : `
        <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                Tidak ada data lembur
            </td>
        </tr>
    `;

    data.forEach(item => {
        tbody.innerHTML += `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatDate(item.tanggal)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.proyek?.nama || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.userprofile?.nama_lengkap || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editLembur(${item.id})" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</button>
                    <button onclick="deleteLembur(${item.id})" class="text-red-600 hover:text-red-900">Hapus</button>
                </td>
            </tr>
        `;
    });
}

function updateSummary(data) {
    const today = new Date().toISOString().split('T')[0];
    const todayLembur = data.filter(item => {
        const itemDate = new Date(item.tanggal).toISOString().split('T')[0];
        return itemDate === today;
    }).length;
    const totalLembur = data.length;
    const proyekAktif = new Set(data.map(item => item.proyek?.id).filter(Boolean)).size;

    document.getElementById('totalLembur').textContent = totalLembur;
    document.getElementById('proyekAktif').textContent = proyekAktif;
    document.getElementById('lemburHariIni').textContent = todayLembur;
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
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query: proyekQuery })
        });

        const proyekData = await response.json();
        console.log('Proyek data:', proyekData.data?.allProyeks);

        if (proyekData.errors) {
            throw new Error(proyekData.errors.map(e => e.message).join(', '));
        }

        populateDropdown('filterProyek', proyekData.data.allProyeks, 'id', 'nama', 'Semua Proyek');
        populateDropdown('addProyek', proyekData.data.allProyeks, 'id', 'nama', 'Pilih Proyek');
        populateDropdown('editProyek', proyekData.data.allProyeks, 'id', 'nama', 'Pilih Proyek');
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

async function editLembur(id) {
    try {
        const query = `
            query {
                lembur(id: ${id}) {
                    id
                    tanggal
                    proyek { id nama }
                    user_profile_id
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
        console.log('GraphQL response (editLembur):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        const data = result.data.lembur;
        if (data) {
            const form = document.getElementById('editLemburForm');
            form.querySelector('input[name="id"]').value = data.id;
            form.querySelector('input[name="tanggal"]').value = data.tanggal;
            form.querySelector('select[name="proyek_id"]').value = data.proyek?.id || '';
            openModal('editLemburModal');
        }
    } catch (error) {
        console.error('Error loading lembur for edit:', error);
        showError('Gagal memuat data untuk edit: ' + error.message);
    }
}

async function deleteLembur(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus lembur ini?')) return;

    try {
        const mutation = `mutation { deleteLembur(id: ${id}) { id } }`;
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query: mutation })
        });

        const result = await response.json();
        console.log('GraphQL response (deleteLembur):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        if (result.data) {
            loadLemburData(currentPage, currentFilters);
        }
    } catch (error) {
        console.error('Error deleting lembur:', error);
        showError('Gagal menghapus lembur: ' + error.message);
    }
}

function filterLembur() {
    const proyekId = document.getElementById('filterProyek').value;
    currentFilters = {
        tanggal: document.getElementById('filterTanggal').value,
        proyek_id: proyekId ? parseInt(proyekId) : null
    };
    console.log('Applying filters:', currentFilters);
    currentPage = 1;
    loadLemburData(currentPage, currentFilters);
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
    loadLemburData(currentPage, currentFilters);
}

function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
    errorDiv.innerHTML = `<span>${message}</span><button onclick="this.parentElement.remove()" class="ml-4 text-red-700">x</button>`;
    document.body.appendChild(errorDiv);
    setTimeout(() => errorDiv.remove(), 5000);
}

function validateFormData(input) {
    if (!input.tanggal) return 'Tanggal harus diisi';
    if (!userProfileId || isNaN(parseInt(userProfileId))) return 'User profile ID tidak valid. Periksa konfigurasi autentikasi.';
    return null;
}

document.getElementById('addLemburForm').addEventListener('submit', async (e) => {
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
            createLembur(input: {
                user_profile_id: ${parseInt(userProfileId)}
                proyek_id: ${input.proyek_id ? parseInt(input.proyek_id) : null}
                tanggal: "${input.tanggal}"
            }) {
                id
                tanggal
            }
        }
    `;

    try {
        console.log('Sending mutation (createLembur):', mutation);
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query: mutation })
        });

        const result = await response.json();
        console.log('GraphQL response (createLembur):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        if (result.data) {
            closeModal('addLemburModal', 'addLemburForm');
            loadLemburData(currentPage, currentFilters);
        }
    } catch (error) {
        console.error('Error creating lembur:', error);
        showError('Gagal menambahkan lembur: ' + error.message);
    }
});

document.getElementById('editLemburForm').addEventListener('submit', async (e) => {
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
            updateLembur(id: ${input.id}, input: {
                user_profile_id: ${parseInt(userProfileId)}
                proyek_id: ${input.proyek_id ? parseInt(input.proyek_id) : null}
                tanggal: "${input.tanggal}"
            }) {
                id
                tanggal
            }
        }
    `;

    try {
        console.log('Sending mutation (updateLembur):', mutation);
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ query: mutation })
        });

        const result = await response.json();
        console.log('GraphQL response (updateLembur):', result);
        if (result.errors) {
            throw new Error(result.errors.map(e => e.message).join(', '));
        }

        if (result.data) {
            closeModal('editLemburModal', 'editLemburForm');
            loadLemburData(currentPage, currentFilters);
        }
    } catch (error) {
        console.error('Error updating lembur:', error);
        showError('Gagal memperbarui lembur: ' + error.message);
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
    loadLemburData();
    loadDropdownData();
});