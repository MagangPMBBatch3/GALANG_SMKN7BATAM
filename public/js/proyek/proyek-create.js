
function openAddProyekModal() {
    document.getElementById('modalAddProyek').classList.remove('hidden');
}

function closeAddProyekModal() {
    document.getElementById('modalAddProyek').classList.add('hidden');
}

async function createProyek() {
    const kode = document.getElementById('addProyekKode').value.trim();
    const nama = document.getElementById('addProyekNama').value.trim();
    const tanggal = document.getElementById('addProyekTanggal').value;
    const nama_sekolah = document.getElementById('addProyekNamaSekolah').value.trim();

    if (!kode || !nama || !tanggal || !nama_sekolah) {
        alert('Semua kolom wajib diisi!');
        return;
    }

    const mutation = `
        mutation {
            createProyek(input: {
                kode: "${kode}",
                nama: "${nama}",
                tanggal: "${tanggal}",
                nama_sekolah: "${nama_sekolah}"
            }) {
                id
                nama
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    closeAddProyekModal();
    loadProyekData();
}
