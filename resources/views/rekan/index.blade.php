<x-layouts.main title="Rekan Kerja">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 rounded-2xl shadow-xl p-6 md:p-8 mb-6 md:mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Rekan Kerja</h1>
                    <p class="text-blue-100 text-base md:text-lg opacity-90">Lihat profil rekan kerja Anda</p>
                </div>
                <div class="text-center md:text-right mt-4 md:mt-0">
                    <div class="text-white text-sm md:text-base">
                    </div>
                </div>
            </div>
        </div>

        <div id="userProfilesContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        </div>

        <div id="loadingIndicator" class="text-center py-12">
            <div class="bg-white rounded-xl shadow-lg p-8 max-w-md mx-auto">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-blue-600 mx-auto mb-4"></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Memuat Data...</h3>
                <p class="text-gray-600 text-sm">Sedang memuat data rekan kerja.</p>
            </div>
        </div>

        <div id="noProfilesMessage" class="text-center py-12 hidden">
            <div class="bg-white rounded-xl shadow-lg p-8 max-w-md mx-auto">
                <div class="p-3 bg-gray-100 rounded-full w-12 h-12 mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Rekan Kerja</h3>
                <p class="text-gray-600 text-sm">Belum ada data profil pengguna yang tersedia.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalViewUserProfile');
            if (modal) {
                modal.style.display = 'none'; 
            }
        }, { once: true });
    </script>

    @include('components.rekan.modal-view')

    <script src="{{ asset('js/rekan/rekan.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadUserProfiles().then(profiles => {
                const loadingIndicator = document.getElementById('loadingIndicator');
                const noProfilesMessage = document.getElementById('noProfilesMessage');
                
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
                
                if (profiles.length === 0) {
                    if (noProfilesMessage) {
                        noProfilesMessage.classList.remove('hidden');
                    }
                } else {
                    renderUserProfiles(profiles);
                }
            }).catch(error => {
                console.error('Error loading user profiles:', error);
                const loadingIndicator = document.getElementById('loadingIndicator');
                const noProfilesMessage = document.getElementById('noProfilesMessage');
                
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
                
                if (noProfilesMessage) {
                    noProfilesMessage.classList.remove('hidden');
                    noProfilesMessage.querySelector('h3').textContent = 'Error Memuat Data';
                    noProfilesMessage.querySelector('p').textContent = 'Terjadi kesalahan saat memuat data rekan kerja.';
                }
            });
        });
    </script>
</x-layouts.main>