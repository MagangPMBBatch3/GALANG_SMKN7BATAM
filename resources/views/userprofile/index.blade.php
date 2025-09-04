<x-layouts.main title="My Profile">
    @php
        $user = Auth::user();
        $userProfile = \App\Models\UserProfile\UserProfile::where('user_id', Auth::id())->first();
        \Log::info('Authenticated User ID: ' . Auth::id() . ', Email: ' . ($user ? $user->email : 'None') . ', User Profile ID: ' . ($userProfile ? $userProfile->id : 'None') . ', User Profile Data: ' . json_encode($userProfile));
    @endphp
    @if($userProfile)
        <x-layouts.profile.profile-header :userProfile="$userProfile" />

        <div class="bg-white rounded-3xl shadow-lg p-8 max-w-4xl mx-auto transition-all duration-300 hover:shadow-2xl">
            <div id="userProfileContainer" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <x-layouts.profile.profile-stats-card
                        title="Total Proyek"
                        :value="\App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->distinct('proyek_id')->count('proyek_id')"
                        subtext="+{{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('created_at', '>=', now()->subDays(30))->distinct('proyek_id')->count('proyek_id') }} baru bulan ini"
                        subtextColor="text-green-600"
                        gradientFrom="blue-50"
                        gradientTo="blue-100"
                    />
                    <x-layouts.profile.profile-stats-card
                        title="Tugas Aktif"
                        :value="\App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('status_id', '!=', 5)->count()"
                        subtext="{{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('status_id', 3)->count() }} dalam proses"
                        gradientFrom="green-50"
                        gradientTo="green-100"
                    />
                    <x-layouts.profile.profile-stats-card
                        title="Tugas Selesai"
                        :value="\App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('status_id', 1)->count()"
                        subtext="{{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->where('status_id', 1)->where('updated_at', '>=', now()->subDays(30))->count() }} selesai bulan ini"
                        gradientFrom="purple-50"
                        gradientTo="purple-100"
                    />
                    <x-layouts.profile.profile-stats-card
                        title="Total Jam Kerja"
                        :value="\App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->sum('jumlah_jam') . ' jam'"
                        subtext=""
                        gradientFrom="yellow-50"
                        gradientTo="yellow-100"
                    />
                </div>

                <x-layouts.profile.profile-details :user="$user" :userProfile="$userProfile" />

                <x-layouts.profile.recent-activities :userProfile="$userProfile" />

                <x-layouts.profile.edit-profile-button :userProfile="$userProfile" />
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