# Dokumentasi Halaman Jam Kerja

## Deskripsi
Halaman Jam Kerja adalah fitur utama untuk mengelola data jam kerja karyawan dalam sistem progres project. Fitur ini memungkinkan user untuk mencatat, mengedit, dan menghapus data jam kerja dengan berbagai parameter seperti proyek, aktivitas, status, dan mode kerja.

## Fitur Utama

### 1. Tampilan Data
- **Tabel Jam Kerja**: Menampilkan semua data jam kerja dalam format tabel
- **Kolom yang ditampilkan**:
  - No (nomor urut)
  - Nama Karyawan
  - No WBS
  - Kode Proyek
  - Aktivitas
  - Tanggal
  - Jumlah Jam
  - Keterangan
  - Status
  - Mode
  - Aksi (Edit/Hapus)

### 2. Tambah Data
- **Modal Tambah**: Form popup untuk menambahkan data baru
- **Field yang tersedia**:
  - Nama Karyawan (dropdown dari user profile)
  - No WBS (text input)
  - Kode Proyek (dropdown dari master proyek)
  - Aktivitas (dropdown dari master aktivitas)
  - Tanggal (date picker)
  - Jumlah Jam (number input dengan step 0.5)
  - Keterangan (textarea)
  - Status (dropdown dari master status jam kerja)
  - Mode (dropdown dari master mode jam kerja)

### 3. Edit Data
- **Modal Edit**: Form popup untuk mengedit data yang sudah ada
- **Pre-populated**: Semua field akan terisi dengan data yang sudah ada
- **Validasi**: Validasi input yang sama dengan tambah data

### 4. Hapus Data
- **Konfirmasi Hapus**: Modal konfirmasi sebelum menghapus data
- **Soft Delete**: Data tidak benar-benar dihapus, hanya diberi flag deleted_at

### 5. Filter dan Pencarian
- **Server-side processing**: Data diambil secara dinamis dari database
- **Responsive**: Tabel responsive untuk mobile dan desktop

## Cara Penggunaan

### Akses Halaman
1. Login ke sistem
2. Navigasi ke menu "Progres Kerja" di sidebar
3. Klik "Jam Kerja"

### Menambah Data
1. Klik tombol "Tambah Jam Kerja" di pojok kanan atas
2. Isi semua field yang diperlukan
3. Klik "Simpan" untuk menyimpan data

### Mengedit Data
1. Klik tombol edit (icon pensil) pada baris yang ingin diedit
2. Ubah data yang diperlukan
3. Klik "Update" untuk menyimpan perubahan

### Menghapus Data
1. Klik tombol hapus (icon trash) pada baris yang ingin dihapus
2. Konfirmasi penghapusan di modal yang muncul
3. Klik "Hapus" untuk menghapus data

## Teknologi yang Digunakan

### Backend
- **Laravel**: Framework PHP untuk backend
- **GraphQL**: Query language untuk API
- **Lighthouse**: Laravel package untuk GraphQL
- **MySQL**: Database utama

### Frontend
- **jQuery**: Library JavaScript
- **DataTables**: Plugin untuk tabel interaktif
- **Bootstrap**: Framework CSS
- **SweetAlert2**: Untuk notifikasi dan modal
- **Font Awesome**: Icon library

### GraphQL Queries
#### Query untuk mengambil semua data jam kerja
```graphql
{
  allJamKerja {
    id
    no_wbs
    kode_proyek
    tanggal
    jumlah_jam
    keterangan
    userprofile {
      nama
    }
    aktivitas {
      nama_aktivitas
    }
    status {
      nama_status
    }
    mode {
      nama_mode
    }
  }
}
```

#### Mutation untuk menambah data
```graphql
mutation {
  createJamKerja(input: {
    user_profile_id: 1
    no_wbs: "WBS001"
    kode_proyek: "PRO001"
    aktivitas_id: 1
    tanggal: "2024-01-20"
    jumlah_jam: 8.5
    keterangan: "Deskripsi pekerjaan"
    status_id: 1
    mode_id: 1
  }) {
    id
  }
}
```

#### Mutation untuk update data
```graphql
mutation {
  updateJamKerja(
    id: 1
    input: {
      user_profile_id: 1
      no_wbs: "WBS001"
      kode_proyek: "PRO001"
      aktivitas_id: 1
      tanggal: "2024-01-20"
      jumlah_jam: 8.5
      keterangan: "Deskripsi pekerjaan"
      status_id: 1
      mode_id: 1
    }
  ) {
    id
  }
}
```

#### Mutation untuk delete data
```graphql
mutation {
  deleteJamKerja(id: 1) {
    id
  }
}
```

## Struktur File

```
resources/views/jam-kerja/
├── index.blade.php          # Halaman utama jam kerja

public/js/jam-kerja/
├── jam-kerja.js            # JavaScript untuk fungsionalitas

public/css/jam-kerja.css    # Custom CSS untuk styling

routes/web.php              # Route untuk akses halaman
app/Http/Controllers/
└── AuthController/
    └── AuthController.php  # Controller untuk halaman
```

## Troubleshooting

### Error: Data tidak muncul di tabel
- Cek koneksi ke database
- Pastikan GraphQL endpoint aktif
- Cek console browser untuk error JavaScript

### Error: Dropdown tidak terisi
- Pastikan data master sudah ada (user, proyek, aktivitas, status, mode)
- Cek query GraphQL untuk dropdown data
- Pastikan tidak ada error CORS

### Error: Form tidak bisa disimpan
- Cek validasi input
- Pastikan semua field required sudah terisi
- Cek console untuk error GraphQL mutation

## Maintenance

### Update Dependencies
```bash
composer update
npm update
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Rebuild Assets
```bash
npm run dev
# atau
npm run build
```

## Support
Untuk bantuan atau pertanyaan, hubungi tim development atau buat issue di repository project.
