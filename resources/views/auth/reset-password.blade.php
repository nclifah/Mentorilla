@extends('layouts.app')

@section('title', 'Reset Password - Mentorilla')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <h2 class="text-3xl font-bold text-center mb-8">Atur Ulang Password</h2>

            <div id="message" class="hidden mb-4 px-3 py-2 rounded-lg text-sm"></div>

            <form id="resetForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" required value="{{ $email }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password Baru</label>
                    <input type="password" id="password" required minlength="6"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="Minimal 6 karakter">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="Ulangi password baru">
                </div>

                <button type="submit" id="submitBtn"
                        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const resetToken = @json($token);

function showMessage(text, isError) {
    const box = document.getElementById('message');
    box.textContent = text;
    box.className = 'mb-4 px-3 py-2 rounded-lg text-sm ' +
        (isError ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700');
}

document.getElementById('resetForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;

    try {
        const response = await axios.post('/api/reset-password', {
            token: resetToken,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value
        });
        showMessage(response.data.message || 'Password berhasil diubah.', false);
        setTimeout(() => window.location.href = '/login', 1500);
    } catch (error) {
        const data = error.response?.data;
        const firstError = data?.errors ? Object.values(data.errors)[0][0] : null;
        showMessage(data?.error || firstError || 'Gagal mengatur ulang password.', true);
        btn.disabled = false;
    }
});
</script>
@endsection
