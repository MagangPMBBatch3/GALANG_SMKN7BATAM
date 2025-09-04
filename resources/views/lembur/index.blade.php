<x-layouts.main title="Lembur">
    <div class="max-w-xs sm:max-w-sm md:max-w-screen-sm mx-auto px-4 py-6 md:py-8">
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <x-layouts.progresLembur.header-lembur title="Lembur" modalId="addLemburModal" buttonText="Tambah Lembur" />
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-layouts.progresLembur.stats-card
                    title="Total Lembur"
                    id="totalLembur"
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
                    title="Lembur Hari Ini"
                    id="lemburHariIni"
                    value="0"
                    bgColor="yellow-100"
                    textColor="yellow-800"
                    valueColor="yellow-600"
                />
            </div>
            <x-layouts.progresLembur.lembur-filters />
            <x-layouts.progresLembur.lembur-table />
            <x-layouts.progresLembur.pagination />
        </div>
    </div>
    <x-layouts.progresLembur.add-lembur-modal />
    <x-layouts.progresLembur.edit-lembur-modal />
</x-layouts.main>

<script src="{{ asset('js/lembur/lembur.js') }}"></script>