@extends('layouts.app')

@section('title', 'Dashboard - Mentorilla')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="mt-2 text-indigo-100">Selamat datang kembali, <span id="userName" class="font-semibold"></span>! 👋</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4">
    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Booking</p>
                    <p class="text-3xl font-bold text-gray-800" id="totalBookings">0</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Booking Aktif</p>
                    <p class="text-3xl font-bold text-gray-800" id="activeBookings">0</p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalSpent">Rp 0</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-white">Booking Terakhir</h2>
                <p class="text-indigo-100 text-sm">Riwayat aktivitas booking Anda</p>
            </div>
            <a href="/mentors" class="bg-white text-indigo-600 px-6 py-2 rounded-lg font-semibold hover:shadow-lg transition">
                + Booking Baru
            </a>
        </div>

        <div class="p-6">
            <div id="bookingsList" class="space-y-4">
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gray-200 border-t-indigo-600"></div>
                    <p class="text-gray-500 mt-2">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <a href="/mentors" class="bg-white rounded-xl shadow-lg p-8 card-hover border-l-4 border-indigo-500">
            <div class="flex items-center">
                <div class="bg-indigo-100 p-4 rounded-full">
                    <span class="text-3xl">🔍</span>
                </div>
                <div class="ml-4">
                    <h3 class="font-bold text-lg text-gray-800">Cari Mentor</h3>
                    <p class="text-gray-600">Temukan mentor terbaik sesuai kebutuhan</p>
                </div>
            </div>
        </a>

        <a href="/bookings" class="bg-white rounded-xl shadow-lg p-8 card-hover border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="bg-purple-100 p-4 rounded-full">
                    <span class="text-3xl">📅</span>
                </div>
                <div class="ml-4">
                    <h3 class="font-bold text-lg text-gray-800">Kelola Booking</h3>
                    <p class="text-gray-600">Lihat semua riwayat booking Anda</p>
                </div>
            </div>
        </a>
    </div>
</div>

<script>
async function loadDashboard() {
    const token = localStorage.getItem('auth_token');
    const user = JSON.parse(localStorage.getItem('user') || '{}');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    // ⭐ REDIRECT MENTOR KE DASHBOARD MENTOR
    if (user.role === 'mentor') {
        window.location.href = '/dashboard/mentor';
        return;
    }

    document.getElementById('userName').textContent = user.name || 'User';

    try {
        const response = await axios.get('/api/bookings', {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        const bookings = response.data;

        document.getElementById('totalBookings').textContent = bookings.length;
        document.getElementById('activeBookings').textContent =
            bookings.filter(b => ['confirmed', 'pending'].includes(b.status)).length;

        const totalSpent = bookings.reduce((sum, b) => sum + parseFloat(b.total_price), 0);
        document.getElementById('totalSpent').textContent = `Rp ${totalSpent.toLocaleString('id-ID')}`;

        const bookingsList = document.getElementById('bookingsList');
        if (bookings.length === 0) {
            bookingsList.innerHTML = `
                <div class="text-center py-12">
                    <span class="text-6xl">📚</span>
                    <p class="text-gray-500 mt-4 text-lg">Belum ada booking</p>
                    <a href="/mentors" class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Mulai Booking Sekarang
                    </a>
                </div>
            `;
        } else {
            bookingsList.innerHTML = bookings.slice(0, 5).map(booking => `
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xl font-bold">
                                ${booking.mentor.user.name.charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">${booking.mentor.user.name}</h3>
                                <p class="text-sm text-indigo-600">${booking.mentor.category.name}</p>
                                <p class="text-sm text-gray-600 mt-1">${booking.mentor.specialization}</p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span>📅 ${new Date(booking.booking_date).toLocaleDateString('id-ID')}</span>
                                    <span>🕐 ${booking.start_time} - ${booking.end_time}</span>
                                    <span>⏱️ ${booking.duration_hours} jam</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full ${
                                booking.status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                booking.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                booking.status === 'completed' ? 'bg-blue-100 text-blue-800' :
                                'bg-red-100 text-red-800'
                            }">
                                ${booking.status === 'confirmed' ? '✓ Dikonfirmasi' :
                                  booking.status === 'pending' ? '⏰ Pending' :
                                  booking.status === 'completed' ? '✓ Selesai' :
                                  '✗ Dibatalkan'}
                            </span>
                            <p class="font-bold text-lg text-gray-800 mt-2">Rp ${parseFloat(booking.total_price).toLocaleString('id-ID')}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    } catch (error) {
        console.error('Error:', error);
        if (error.response?.status === 401) {
            localStorage.clear();
            window.location.href = '/login';
        }
    }
}

loadDashboard();
</script>
@endsection
