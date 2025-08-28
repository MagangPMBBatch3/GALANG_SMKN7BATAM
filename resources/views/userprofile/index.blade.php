<x-layouts.main title="My Profile">
    @php
        $user = Auth::user();
        $userProfile = \App\Models\UserProfile\UserProfile::where('user_id', Auth::id())->first();
        \Log::info('Authenticated User ID: ' . Auth::id() . ', Email: ' . ($user ? $user->email : 'None') . ', User Profile ID: ' . ($userProfile ? $userProfile->id : 'None') . ', User Profile Data: ' . json_encode($userProfile));
    @endphp
    @if($userProfile)
        <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-3xl shadow-2xl p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 shadow-lg ring-4 ring-white">
                        <img id="userProfileFoto" src="{{ $userProfile->foto ?? '' }}" alt="Profile Photo" class="{{ $userProfile->foto ? '' : 'hidden' }}">
                    </div>
                    <div>
                        <h1 class="text-4xl font-extrabold text-white mb-2" id="userProfileNamaLengkap">{{ $userProfile->nama_lengkap ?? '-' }}</h1>
                        <p class="text-indigo-100 text-lg opacity-90">Kelola informasi pribadi Anda</p>
                    </div>
                </div>
                <div class="text-right mt-4 md:mt-0">
                    <div class="text-white">
                        <p class="text-sm opacity-75">Terakhir Diperbarui</p>
                        <p class="text-xl font-bold">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-8 max-w-4xl mx-auto transition-all duration-300 hover:shadow-2xl">
            <div id="userProfileContainer" class="space-y-8">
               
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-6 text-center transform hover:scale-105 transition-transform">
                        <p class="text-sm font-medium text-gray-600">Total Proyek</p>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->distinct('proyek_id')->count('proyek_id') }}
                        </p>
                        <p class="text-sm text-green-600 mt-2">
                            +{{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('created_at', '>=', now()->subDays(30))->distinct('proyek_id')->count('proyek_id') }} baru bulan ini
                        </p>
                    </div>
                    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 text-center transform hover:scale-105 transition-transform">
                        <p class="text-sm font-medium text-gray-600">Tugas Aktif</p>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('status_id', '!=', 5)->count() }}
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            {{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('status_id', 3)->count() }} dalam proses
                        </p>
                    </div>
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-2xl p-6 text-center transform hover:scale-105 transition-transform">
                        <p class="text-sm font-medium text-gray-600">Tugas Selesai</p>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('status_id', 1)->count() }}
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            {{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('status_id', 1)->where('updated_at', '>=', now()->subDays(30))->count() }} selesai bulan ini
                        </p>
                    </div>
                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-2xl p-6 text-center transform hover:scale-105 transition-transform">
                        <p class="text-sm font-medium text-gray-600">Total Jam Kerja</p>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->sum('jumlah_jam') }} jam
                        </p>
                       
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">ID</label>
                        <p id="userProfileId" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->id ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">NRP</label>
                        <p id="userProfileNrp" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->nrp ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email</label>
                        <p id="userProfileEmail" class="mt-1 text-gray-900 font-semibold">{{ $user->email ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Alamat</label>
                        <p id="userProfileAlamat" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->alamat ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Level</label>
                        <p id="userProfileLevel" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->level->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Status</label>
                        <p id="userProfileStatus" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->status->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Bagian</label>
                        <p id="userProfileBagian" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->bagian->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Total Jam Kerja</label>
                        <p class="mt-1 text-gray-900 font-semibold">
                            {{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->sum('jumlah_jam') }} jam
                        </p>
                    </div>
                </div>

                
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        @php
                            $recentTasks = \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->latest()->take(3)->get();
                        @endphp
                        @foreach($recentTasks as $task)
                            <div class="border-l-4 border-indigo-500 pl-4 py-3 bg-gray-50 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $task->proyek->nama ?? '-' }}</h4>
                                        <p class="text-sm text-gray-600">{{ $task->aktivitas->nama ?? '-' }}</p>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $task->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="mt-2">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Status</span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->status_id == 1 ? 'bg-green-100 text-green-800' : ($task->status_id == 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $task->status->nama ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($recentTasks->isEmpty())
                            <div class="text-center text-gray-500 p-4 bg-gray-50 rounded-lg">
                                Tidak ada aktivitas terbaru
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end">
    <button onclick="openEditUserProfileModal()" id="editProfileButton" 
            class="flex items-center p-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-lg hover:from-yellow-500 hover:to-yellow-600 transition-all"
            data-profile='{{ json_encode([
                "id" => $userProfile->id ?? "",
                "user_id" => $userProfile->user_id ?? "",
                "nama_lengkap" => $userProfile->nama_lengkap ?? "",
                "nrp" => $userProfile->nrp ?? "",
                "alamat" => $userProfile->alamat ?? "",
                "foto" => $userProfile->foto ?? "",
                "bagian_id" => $userProfile->bagian_id ?? "",
                "level_id" => $userProfile->level_id ?? "",
                "status_id" => $userProfile->status_id ?? ""
            ]) }}'>
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <span>Edit Profil</span>
    </button>
</div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl shadow-lg p-8 max-w-4xl mx-auto text-center text-gray-500">
            Tidak ada data profil untuk pengguna ini. Silakan buat profil terlebih dahulu.
        </div>
    @endif

    @include('components.userprofile.modal-edit')

    <script>
        window.authUserId = {{ Auth::id() ?? 0 }};
    </script>
    <script src="{{ asset('js/userprofile/userprofile.js') }}"></script>
    <script src="{{ asset('js/userprofile/userprofile-edit.js') }}"></script>
</x-layouts.main>