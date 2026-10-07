@extends('layouts.app')

@section('title', 'Register - Mentorilla')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <h2 class="text-3xl font-bold text-center mb-8">Daftar Akun Baru</h2>

            <form id="registerForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" id="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="John Doe">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="your@email.com">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">No. Telepon</label>
                    <input type="tel" id="phone"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="08123456789">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="••••••••">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="••••••••">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Daftar Sebagai</label>
                    <select id="role" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
                        <option value="user">Siswa / Pencari Mentor</option>
                        <option value="mentor">Mentor / Pengajar</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center mt-6 text-gray-600">
                Sudah punya akun?
                <a href="/login" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    Login di sini
                </a>
            </p>
        </div>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('password_confirmation').value;
    const role = document.getElementById('role').value;

    try {
        const response = await axios.post('/api/register', {
            name: name,
            email: email,
            phone: phone,
            password: password,
            password_confirmation: password_confirmation,
            role: role
        });

        if (response.data.token) {
            localStorage.setItem('auth_token', response.data.token);
            localStorage.setItem('user', JSON.stringify(response.data.user));

            alert('Registrasi berhasil!');
            window.location.href = '/dashboard';
        }
    } catch (error) {
        console.error('Error:', error);
        const errors = error.response?.data?.errors;
        if (errors) {
            let errorMsg = '';
            for (let key in errors) {
                errorMsg += errors[key].join('\n') + '\n';
            }
            alert(errorMsg);
        } else {
            alert('Registrasi gagal! Periksa data Anda.');
        }
    }
});
</script>
@endsection
