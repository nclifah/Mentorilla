@extends('layouts.app')

@section('title', 'Lupa Password - Mentorilla')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <h2 class="text-3xl font-bold text-center mb-4">Lupa Password</h2>
            <p class="text-center text-gray-600 mb-8">
                Masukkan email akunmu. Kami akan mengirim tautan untuk mengatur ulang password.
            </p>

            <div id="message" class="hidden mb-4 px-3 py-2 rounded-lg text-sm"></div>

            <form id="forgotForm">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                           placeholder="your@email.com">
                </div>

                <button type="submit" id="submitBtn"
                        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                    Kirim Tautan Reset
                </button>
            </form>

            <p class="text-center mt-6 text-gray-600">
                <a href="/login" class="text-indigo-600 hover:text-indigo-800 font-semibold">Kembali ke Login</a>
            </p>
        </div>
    </div>
</div>

<script>
function showMessage(text, isError) {
    const box = document.getElementById('message');
    box.textContent = text;
    box.className = 'mb-4 px-3 py-2 rounded-lg text-sm ' +
        (isError ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700');
}

document.getElementById('forgotForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;

    try {
        const response = await axios.post('/api/forgot-password', {
            email: document.getElementById('email').value
        });
        showMessage(response.data.message || 'Tautan reset telah dikirim.', false);
    } catch (error) {
        const data = error.response?.data;
        const firstError = data?.errors ? Object.values(data.errors)[0][0] : null;
        showMessage(data?.error || firstError || 'Gagal mengirim tautan reset.', true);
    } finally {
        btn.disabled = false;
    }
});
</script>
@endsection
