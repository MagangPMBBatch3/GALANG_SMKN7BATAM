let userProfiles = [];

function openUserProfileModal(profile) {
    console.log('Opening modal for profile:', profile);
    
    if (!profile || !profile.id) {
        console.error('Invalid profile data, aborting modal open:', profile);
        return;
    }
    
    document.getElementById('modalUserProfileId').textContent = profile.id || '-';
    document.getElementById('modalUserProfileNamaLengkap').textContent = profile.nama_lengkap || '-';
    document.getElementById('modalUserProfileNrp').textContent = profile.nrp || '-';
    document.getElementById('modalUserProfileEmail').textContent = profile.user?.email || '-';
    document.getElementById('modalUserProfileAlamat').textContent = profile.alamat || '-';
    document.getElementById('modalUserProfileLevel').textContent = profile.level?.nama || '-';
    document.getElementById('modalUserProfileStatus').textContent = profile.status?.nama || '-';
    document.getElementById('modalUserProfileBagian').textContent = profile.bagian?.nama || '-';
    const fotoElement = document.getElementById('modalUserProfileFoto');
    if (profile.foto) {
        fotoElement.src = profile.foto;
        fotoElement.classList.remove('hidden');
    } else {
        fotoElement.src = '';
        fotoElement.classList.add('hidden');
    }
    
    const modal = document.getElementById('modalViewUserProfile');
    if (modal) {
        modal.style.display = ''; 
        modal.classList.remove('hidden');
    }
    console.log('Modal opened for profile ID:', profile.id);
}

function closeUserProfileModal() {
    const modal = document.getElementById('modalViewUserProfile');
    if (modal) {
        modal.classList.add('hidden');
        console.log('Modal closed');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded event fired, initializing modal listeners');

    const modal = document.getElementById('modalViewUserProfile');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeUserProfileModal();
            }
        });
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeUserProfileModal();
        }
    });

    loadUserProfiles().then(profiles => {
        const loadingIndicator = document.getElementById('loadingIndicator');
        const noProfilesMessage = document.getElementById('noProfilesMessage');
        const userProfilesContainer = document.getElementById('userProfilesContainer');
        
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

async function loadUserProfiles() {
    console.log('Loading user profiles...');
    try {
        const query = `
            query {
                allUserProfiles {
                    id
                    nama_lengkap
                    nrp
                    alamat
                    foto
                    user {
                        email
                    }
                    bagian {
                        nama
                    }
                    level {
                        nama
                    }
                    status {
                        nama
                    }
                }
            }
        `;
        
        const response = await fetch('/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ query })
        });
        
        const data = await response.json();
        
        if (data.errors) {
            console.error('GraphQL errors:', data.errors);
            return [];
        }
        
        userProfiles = data.data?.allUserProfiles || [];
        console.log('User profiles loaded:', userProfiles.length);
        return userProfiles;
    } catch (error) {
        console.error('Error loading user profiles:', error);
        return [];
    }
}

function renderUserProfiles(profiles) {
    const container = document.getElementById('userProfilesContainer');
    if (!container) {
        console.error('User profiles container not found');
        return;
    }
    
    if (profiles.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
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
        `;
        console.log('No profiles to render');
        return;
    }
    
    const profilesHTML = profiles.map(profile => `
        <div class="bg-white rounded-xl shadow-lg p-4 hover:shadow-2xl hover:bg-gradient-to-r from-blue-50 to-white transition-all duration-300 cursor-pointer"
             onclick="openUserProfileById('${profile.id}')" data-id="${profile.id}">
            <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 rounded-full overflow-hidden bg-gray-200 shadow-md ring-4 ring-white mx-auto sm:mx-0">
                    ${profile.foto ?
                        `<img src="${profile.foto}" alt="${sanitizeHTML(profile.nama_lengkap)}" class="w-full h-full object-cover">` :
                        `<div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                            <span class="text-white text-2xl sm:text-3xl font-bold">${sanitizeHTML(profile.nama_lengkap ? profile.nama_lengkap.charAt(0) : 'U')}</span>
                        </div>`
                    }
                </div>

                <div class="flex-1 text-center sm:text-left space-y-2">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">${sanitizeHTML(profile.nama_lengkap || '-')}</h2>
                    <p class="text-gray-600 text-sm">${sanitizeHTML(profile.nrp || '-')}</p>
                    ${profile.bagian ? `<p class="text-indigo-600 font-medium text-sm">${sanitizeHTML(profile.bagian.nama)}</p>` : ''}
                    ${profile.level ? `<p class="text-green-600 text-sm">${sanitizeHTML(profile.level.nama)}</p>` : ''}
                </div>

                <div class="flex-shrink-0">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 shadow-md">
                        ${sanitizeHTML(profile.status?.nama || 'Aktif')}
                    </span>
                </div>
            </div>
        </div>
    `).join('');
    
    container.innerHTML = profilesHTML;
    console.log('Profiles rendered:', profiles.length);
}

function openUserProfileById(profileId) {
    console.log('Attempting to open profile with ID:', profileId);
    const profile = userProfiles.find(p => p.id === profileId);
    if (profile) {
        openUserProfileModal(profile);
    } else {
        console.error('Profile not found for ID:', profileId);
    }
}

function sanitizeHTML(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}