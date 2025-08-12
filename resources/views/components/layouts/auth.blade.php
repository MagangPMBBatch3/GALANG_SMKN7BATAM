<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title ?? 'Login' }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="max-w-md w-full bg-white p-8 rounded shadow-md">
            {{ $slot }}
        </div>
        
    </body>
</html>