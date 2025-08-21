let currentPage = 1;
let searchQuery = '';

document.addEventListener('DOMContentLoaded', function() {
    loadJenisPesan();
    
    document.getElementById('searchInput').addEventListener('input', function(e) {
        searchQuery = e.target.value;
        currentPage = 1;
        loadJenisPesan();
    });
});

async function loadJenisPesan() {
    try {
        const query = `
            query {
                allJenisPesan {
                    id
                    nama
                    created_at
                    updated_at
                }
            }
        `;

        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ query })
        });

        const result = await response.json();
        
        if (result.errors) {
            console.error('GraphQL errors:', result.errors);
            return;
        }

        const jenisPesanList = result.data.allJenisPesan;
        displayJenisPesan(jenisPesanList);
        
    } catch (error) {
        console.error('Error loading jenis pesan:', error);
    }
}

function displayJenisPesan(data) {
    const tbody = document.getElementById('jenisPesanTableBody');
    tbody.innerHTML = '';

    if (data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    Tidak ada data jenis pesan
                </td>
            </tr>
        `;
        return;
    }

    data.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.nama || '-'}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formatDate(item.created_at)}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formatDate(item.updated_at)}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button onclick="editJenisPesan(${item.id}, '${item.nama}')" 
                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteJenisPesan(${item.id})" 
                        class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function openModal(mode, id = null, nama = '') {
    const modal = document.getElementById('jenisPesanModal');
    const modalTitle = document.getElementById('modalTitle');
    const form = document.getElementById('jenisPesanForm');
    const jenisPesanId = document.getElementById('jenisPesanId');
    const namaInput = document.getElementById('nama');

    if (mode === 'add') {
        modalTitle.textContent = 'Tambah Jenis Pesan';
        jenisPesanId.value = '';
        namaInput.value = '';
    } else {
        modalTitle.textContent = 'Edit Jenis Pesan';
        jenisPesanId.value = id;
        namaInput.value = nama;
    }

    modal.classList.remove('hidden');
}

function closeModal() {
    const modal = document.getElementById('jenisPesanModal');
    modal.classList.add('hidden');
}

document.getElementById('jenisPesanForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const id = document.getElementById('jenisPesanId').value;
    const nama = document.getElementById('nama').value;

    if (!nama.trim()) {
        alert('Nama jenis pesan tidak boleh kosong');
        return;
    }

    try {
        let mutation, variables;

        if (id) {
            mutation = `
                mutation UpdateJenisPesan($id: ID!, $input: UpdateJenisPesanInput!) {
                    updateJenisPesan(id: $id, input: $input) {
                        id
                        nama
                    }
                }
            `;
            variables = { id, input: { nama } };
        } else {
            mutation = `
                mutation CreateJenisPesan($input: CreateJenisPesanInput!) {
                    createJenisPesan(input: $input) {
                        id
                        nama
                    }
                }
            `;
            variables = { input: { nama } };
        }

        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ query: mutation, variables })
        });

        const result = await response.json();

        if (result.errors) {
            console.error('GraphQL errors:', result.errors);
            alert('Terjadi kesalahan: ' + result.errors[0].message);
            return;
        }

        closeModal();
        loadJenisPesan();
        
    } catch (error) {
        console.error('Error saving jenis pesan:', error);
        alert('Terjadi kesalahan saat menyimpan data');
    }
});

function editJenisPesan(id, nama) {
    openModal('edit', id, nama);
}

async function deleteJenisPesan(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus jenis pesan ini?')) {
        return;
    }

    try {
        const mutation = `
            mutation DeleteJenisPesan($id: ID!) {
                deleteJenisPesan(id: $id) {
                    id
                }
            }
        `;

        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ 
                query: mutation, 
                variables: { id } 
            })
        });

        const result = await response.json();

        if (result.errors) {
            console.error('GraphQL errors:', result.errors);
            alert('Terjadi kesalahan: ' + result.errors[0].message);
            return;
        }

        loadJenisPesan();
        
    } catch (error) {
        console.error('Error deleting jenis pesan:', error);
        alert('Terjadi kesalahan saat menghapus data');
    }
}

window.onclick = function(event) {
    const modal = document.getElementById('jenisPesanModal');
    if (event.target === modal) {
        closeModal();
    }
}
