<x-layouts.main title="Dashboard">
    <x-layouts.dashboard.header />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-layouts.dashboard.stats-card
            title="Total Proyek"
            :value="\App\Models\Proyek\Proyek::count()"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />'
            iconColor="blue-600"
            bgColor="blue-100"
            subtext="+{{ \App\Models\Proyek\Proyek::where('created_at', '>=', now()->subDays(30))->count() }} baru bulan ini"
            subtextColor="text-green-600"
        />
        <x-layouts.dashboard.stats-card
            title="Tugas Aktif"
            :value="\App\Models\JamKerja\JamKerja::where('status_id', '!=', 5)->count()"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />'
            iconColor="green-600"
            bgColor="green-100"
            subtext="{{ \App\Models\JamKerja\JamKerja::where('status_id', 3)->count() }} dalam proses"
        />
        <x-layouts.dashboard.stats-card
            title="Tugas Selesai"
            :value="\App\Models\JamKerja\JamKerja::where('status_id', 1)->count()"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
            iconColor="purple-600"
            bgColor="purple-100"
            subtext="{{ \App\Models\JamKerja\JamKerja::where('status_id', 1)->where('updated_at', '>=', now()->subDays(30))->count() }} selesai bulan ini"
        />
        <x-layouts.dashboard.stats-card
            title="Anggota Tim"
            :value="\App\Models\User\User::count()"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />'
            iconColor="orange-600"
            bgColor="orange-100"
            subtext="{{ \App\Models\User\User::where('created_at', '>=', now()->subDays(30))->count() }} baru bulan ini"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <x-layouts.dashboard.recent-projects />
        <x-layouts.dashboard.task-status />
    </div>

    <x-layouts.dashboard.quick-actions
        :userLevel="auth()->user()->level->nama ?? 'User'"
        :userLevelId="auth()->user()->level_id ?? 0"
    />

    <script>
        window.authUserId = {{ Auth::id() }};
    </script>
    <script src="{{ asset('js/userprofile/userprofile.js') }}"></script>
</x-layouts.main>