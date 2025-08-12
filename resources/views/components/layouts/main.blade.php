<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-grey-100 flex">
    <aside class="w-64 h-screen p-4 bg-blue-400 shadow">
        <h2 class="text-xl text-white font-bold mb-5">Menu</h2>
        <ul>
            <li><a href="#" class="block py-2 hover:bg-blue-500 rounded px-2 text-white">Dashboard</a></li>
            <li><a href="#" class="block py-2 hover:bg-blue-500 rounded px-2 text-white">Bagian</a></li>
            <li><a href="#" class="block py-2 hover:bg-blue-500 rounded px-2 text-white">Level</a></li>
        </ul>
    </aside>
    <div class="flex-1 p-6">
        <form action="/logout" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="flex items-center gap-2 w-full text-left py-2 px-2 rounded text-white bg-red-500 hover:bg-red-600 transition duration-200 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                </svg>
                Logout
            </button>
        </form>
        <div>
            {{ $slot }}