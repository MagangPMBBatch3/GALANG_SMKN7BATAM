<x-layouts.main title="Pesan">
    <div class="container mx-auto h-screen flex flex-col bg-gray-50">
        <div class="flex flex-1 overflow-hidden relative">
            <div id="sidebar" class="fixed inset-y-0 left-0 z-30 w-80 bg-white shadow-lg border-r border-gray-200 transform -translate-x-full md:translate-x-0 md:static md:inset-0 md:w-1/3 transition-transform duration-300 ease-in-out">
                <x-layouts.pesan.sidebar-header :userProfile="auth()->user()->userprofile" :userLevel="auth()->user()->level" />
                <x-layouts.pesan.conversation-list />
            </div>
            <x-layouts.pesan.sidebar-overlay />
            <div class="flex-1 flex flex-col bg-white md:w-2/3">
                <x-layouts.pesan.chat-header />
                <x-layouts.pesan.chat-messages />
                <x-layouts.pesan.send-message-form />
            </div>
        </div>
        <x-layouts.pesan.add-pesan-modal />
        <x-layouts.pesan.styles />
    </div>
    <script src="{{ asset('js/pesan/pesan.js') }}"></script>
</x-layouts.main>