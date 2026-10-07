@extends('layouts.app')

@section('title', 'Login - Mentorilla')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <h2 class="text-3xl font-bold text-center mb-8">Login ke Mentorilla</h2>

            <form id="loginForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="your@email.com">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                    Login
                </button>
            </form>

            <p class="text-center mt-4">
                <a href="/forgot-password" class="text-indigo-600 hover:text-indigo-800 text-sm">Lupa password?</a>
            </p>

            <p class="text-center mt-6 text-gray-600">
                Belum punya akun?
                <a href="/register" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await axios.post('/api/login', {
            email: email,
            password: password
        });

        if (response.data.token) {
            localStorage.setItem('auth_token', response.data.token);
            localStorage.setItem('user', JSON.stringify(response.data.user));

            alert('Login berhasil!');
            window.location.href = '/dashboard';
        }
    } catch (error) {
        console.error('Error:', error);
        alert(error.response?.data?.error || 'Login gagal! Periksa email dan password Anda.');
    }
});
</script>
@endsection
