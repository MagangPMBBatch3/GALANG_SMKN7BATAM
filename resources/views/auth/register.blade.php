<x-layouts.auth title="Register">
    <form id="registerForm" class="bg-white p-6 rounded shadow-md w-69">
        @csrf
        <h1 class="text-2xl font-bold mb-4 text-center">Register</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mb-4">
            <label>Nama</label>
            <input type="text" id="registerName" name="name" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" id="registerEmail" name="email" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password" id="registerPassword" name="password" class="w-full p-2 border rounded" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Register</button>
        <a href="/login" class="block text-center text-blue-500 mt-4 hover:underline">Sudah punya akun? Login</a>
    </form>

    <script src="{{ asset('js/register.js') }}"></script>
</x-layouts.auth>