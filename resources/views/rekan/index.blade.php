<x-layouts.main title="Rekan Kerja">
    <div class="container mx-auto px-4 py-8">
        <x-layouts.rekan.header />
        <x-layouts.rekan.profiles-container />
        <x-layouts.rekan.loading-indicator />
        <x-layouts.rekan.no-profiles-message />
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