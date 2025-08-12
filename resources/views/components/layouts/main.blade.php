<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    <aside class="w-64 h-screen p-4">
        <h2 class="text-xl font-bold mb-5">Menu</h2>
        <ul>
            <li><a href="#" class="block py-2 hover:bg-blue-500 rounded px-2">Dashboard</a></li>
            <li><a href="#" class="block py-2 rounded hover:bg-gray-700">Bagian</a></li>
            <li><a href="#" class="block py-2 rounded hover:bg-gray-700">Level</a></li>
        </ul>
    </aside>
    <div class="flex-1 p-6">
        <form action="/logout" method="POST">
            <button type="submit" class="w-full text-left py-2 hover:bg-red-500 rounded px-2">Logout</button>
        </form>
        <ul>
            <slot></slot>
        </ul>
    </div>
</body>
</html>