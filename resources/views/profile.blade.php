<x-layouts.main title="Profil Pengguna">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Pengaturan Profil</h1>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 p-2 w-full border rounded-lg @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 p-2 w-full border rounded-lg @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $userProfile->nama_lengkap ?? '') }}" class="mt-1 p-2 w-full border rounded-lg @error('nama_lengkap') border-red-500 @enderror" required>
                @error('nama_lengkap')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nrp" class="block text-sm font-medium text-gray-700">NRP</label>
                <input type="text" id="nrp" name="nrp" value="{{ old('nrp', $userProfile->nrp ?? '') }}" class="mt-1 p-2 w-full border rounded-lg @error('nrp') border-red-500 @enderror">
                @error('nrp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $userProfile->alamat ?? '') }}" class="mt-1 p-2 w-full border rounded-lg @error('alamat') border-red-500 @enderror">
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto Profil (opsional)</label>
                @if ($userProfile && $userProfile->foto)
                    <img src="{{ $userProfile->foto }}" alt="Foto Profil" class="h-20 w-20 rounded-full mb-2">
                @endif
                <input type="file" id="foto" name="foto" accept="image/*" class="mt-1 p-2 w-full border rounded-lg @error('foto') border-red-500 @enderror">
                <img id="fotoPreview" class="mt-2 h-20 w-20 rounded-full hidden" alt="Preview Foto">
                @error('foto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded bg-gray-300 text-gray-700">Batal</a>
                <button type="submit" class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('foto')?.addEventListener('change', function(e) {
            const preview = document.getElementById('fotoPreview');
            if (e.target.files[0]) {
                preview.src = URL.createObjectURL(e.target.files[0]);
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
</x-layouts.main>