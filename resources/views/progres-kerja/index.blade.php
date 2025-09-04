<x-layouts.main title="Progress Kerja">
    <div class="max-w-xs sm:max-w-sm md:max-w-screen-sm mx-auto px-4 py-6 md:py-8">
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <x-layouts.progresLembur.header />
            <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-layouts.progresLembur.stats-card
                    title="Total Jam Kerja"
                    id="totalJam"
                    value="0"
                    bgColor="blue-100"
                    textColor="blue-800"
                    valueColor="blue-600"
                />
                <x-layouts.progresLembur.stats-card
                    title="Proyek Aktif"
                    id="proyekAktif"
                    value="0"
                    bgColor="green-100"
                    textColor="green-800"
                    valueColor="green-600"
                />
                <x-layouts.progresLembur.stats-card
                    title="Progress Hari Ini"
                    id="progressHariIni"
                    value="0"
                    bgColor="yellow-100"
                    textColor="yellow-800"
                    valueColor="yellow-600"
                />
                <x-layouts.progresLembur.stats-card
                    title="Persentase Selesai"
                    id="persentaseSelesai"
                    value="0%"
                    bgColor="purple-100"
                    textColor="purple-800"
                    valueColor="purple-600"
                />
            </div>
            <x-layouts.progresLembur.filters />
            <x-layouts.progresLembur.progress-container />
            <x-layouts.progresLembur.pagination />
        </div>
    </div>
    <x-layouts.progresLembur.recent-projects />
    <x-layouts.progresLembur.add-progress-modal />
    <x-layouts.progresLembur.edit-progress-modal />
</x-layouts.main>

<script src="{{ asset('js/progres-kerja/progres-kerja.js') }}"></script>