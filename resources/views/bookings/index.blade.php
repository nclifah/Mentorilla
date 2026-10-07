@extends('layouts.app')

@section('title', 'Riwayat Booking - Mentorilla')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">📚 Riwayat Booking</h1>
        <p class="mt-2 text-indigo-100">Kelola semua booking mentor Anda</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-lg mb-6">
        <div class="border-b border-gray-200 overflow-x-auto">
            <nav class="flex -mb-px">
                <button onclick="filterBookings('all')" class="tab-btn active px-6 py-4 text-sm font-semibold border-b-2 border-indigo-500 text-indigo-600">
                    Semua
                </button>
                <button onclick="filterBookings('pending')" class="tab-btn px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    ⏰ Pending
                </button>
                <button onclick="filterBookings('confirmed')" class="tab-btn px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    ✓ Dikonfirmasi
                </button>
                <button onclick="filterBookings('completed')" class="tab-btn px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    ✓ Selesai
                </button>
                <button onclick="filterBookings('cancelled')" class="tab-btn px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    ✗ Dibatalkan
                </button>
            </nav>
        </div>
    </div>

    <!-- Bookings List -->
    <div id="bookingsList" class="space-y-4">
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-200 border-t-indigo-600"></div>
            <p class="text-gray-500 mt-4">Memuat booking...</p>
        </div>
    </div>
</div>

<script>
let allBookings = [];

async function loadBookings() {
    const token = localStorage.getItem('auth_token');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    try {
        const response = await axios.get('/api/bookings', {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        allBookings = response.data;
        displayBookings(allBookings);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('bookingsList').innerHTML =
            '<div class="text-center py-12"><p class="text-red-500">❌ Gagal memuat data booking</p></div>';
    }
}

function displayBookings(bookings) {
    const bookingsList = document.getElementById('bookingsList');

    if (bookings.length === 0) {
        bookingsList.innerHTML = `
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <span class="text-6xl">📚</span>
                <p class="text-gray-500 mt-4 text-lg font-semibold">Belum ada booking</p>
                <p class="text-gray-400 mt-2">Mulai cari mentor dan buat booking pertama Anda!</p>
                <a href="/mentors" class="inline-block mt-6 px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                    🔍 Cari Mentor Sekarang
                </a>
            </div>
        `;
        return;
    }

    bookingsList.innerHTML = bookings.map(booking => `
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Mentor Info -->
                    <div class="flex items-start gap-4 flex-1">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                            ${booking.mentor.user.name.charAt(0).toUpperCase()}
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800">${booking.mentor.user.name}</h3>
                            <p class="text-sm text-indigo-600 font-semibold">${booking.mentor.category.name}</p>
                            <p class="text-sm text-gray-600 mt-1">${booking.mentor.specialization}</p>

                            <!-- Booking Details -->
                            <div class="grid md:grid-cols-2 gap-x-6 gap-y-2 mt-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="mr-2">📅</span>
                                    <span>${new Date(booking.booking_date).toLocaleDateString('id-ID', {
                                        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
                                    })}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="mr-2">🕐</span>
                                    <span>${booking.start_time} - ${booking.end_time}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="mr-2">⏱️</span>
                                    <span>${booking.duration_hours} jam</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="mr-2">💰</span>
                                    <span class="font-semibold text-indigo-600">Rp ${parseFloat(booking.total_price).toLocaleString('id-ID')}</span>
                                </div>
                            </div>

                            ${booking.notes ? `
                                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                    <p class="text-xs text-gray-500 mb-1">📝 Catatan:</p>
                                    <p class="text-sm text-gray-700">${booking.notes}</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>

                    <!-- Status & Actions -->
                    <div class="text-center md:text-right flex-shrink-0">
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold ${
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

                        ${booking.status === 'pending' ? `
                            <button onclick="cancelBooking(${booking.id})"
                                    class="mt-4 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg text-sm font-semibold transition">
                                ✗ Batalkan Booking
                            </button>
                        ` : ''}
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function filterBookings(status) {
    // Update active tab
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    event.target.classList.add('active', 'border-indigo-500', 'text-indigo-600');
    event.target.classList.remove('border-transparent', 'text-gray-500');

    // Filter bookings
    let filtered = allBookings;
    if (status !== 'all') {
        filtered = allBookings.filter(b => b.status === status);
    }
    displayBookings(filtered);
}

async function cancelBooking(id) {
    if (!confirm('⚠️ Apakah Anda yakin ingin membatalkan booking ini?')) {
        return;
    }

    const token = localStorage.getItem('auth_token');

    try {
        const response = await axios.put(`/api/bookings/${id}`,
            { status: 'cancelled' },
            {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }
        );

        if (response.data) {
            alert('✅ Booking berhasil dibatalkan');
            loadBookings();
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Gagal membatalkan booking');
    }
}

loadBookings();
</script>
@endsection
