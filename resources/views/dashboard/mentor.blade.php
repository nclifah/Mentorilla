@extends('layouts.app')

@section('title', 'Dashboard Mentor - Mentorilla')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">👨‍🏫 Dashboard Mentor</h1>
        <p class="mt-2 text-indigo-100">Kelola booking dari siswa Anda</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4">
        <!-- Form Profil Mentor (tampil jika belum punya profil) -->
    <div id="profileCard" class="hidden bg-white rounded-xl shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Buat Profil Mentor</h2>
        <p class="text-gray-600 mb-6">Lengkapi profil agar siswa dapat menemukan dan memesan Anda.</p>

        <div id="profileMessage" class="hidden mb-4 px-3 py-2 rounded-lg text-sm bg-red-100 text-red-700"></div>

        <form id="profileForm" class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                <select id="pf_category" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
                    <option value="">Pilih kategori</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Spesialisasi</label>
                <input type="text" id="pf_specialization" required placeholder="Contoh: Pemrograman Web"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                <textarea id="pf_bio" rows="3" required placeholder="Ceritakan pengalaman mengajar Anda"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"></textarea>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Pengalaman (tahun)</label>
                <input type="number" id="pf_experience" required min="0" placeholder="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tarif per jam (Rp)</label>
                <input type="number" id="pf_rate" required min="0" placeholder="100000"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pendidikan terakhir</label>
                <input type="text" id="pf_education" required placeholder="Contoh: S1 Informatika"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
            <div class="md:col-span-2">
                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                    Simpan Profil Mentor
                </button>
            </div>
        </form>
    </div>
    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Pending</p>
                    <p class="text-3xl font-bold text-gray-800" id="pendingCount">0</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-full">
                    <span class="text-3xl">⏰</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Dikonfirmasi</p>
                    <p class="text-3xl font-bold text-gray-800" id="confirmedCount">0</p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <span class="text-3xl">✅</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Selesai</p>
                    <p class="text-3xl font-bold text-gray-800" id="completedCount">0</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <span class="text-3xl">✓</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalEarnings">Rp 0</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <span class="text-3xl">💰</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600">
            <h2 class="text-xl font-bold text-white">📋 Booking dari Siswa</h2>
            <p class="text-indigo-100 text-sm">Kelola dan konfirmasi booking</p>
        </div>

        <!-- Filter Tabs -->
        <div class="border-b border-gray-200">
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
            </nav>
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
</div>

<script>
let allBookings = [];
let currentMentorId = null;

function showLoading(text = 'Memuat data...') {
    document.getElementById('bookingsList').innerHTML = `
        <div class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gray-200 border-t-indigo-600"></div>
            <p class="text-gray-500 mt-2">${text}</p>
        </div>
    `;
}

async function loadMentorBookings() {
    showLoading();
    const token = localStorage.getItem('auth_token');
    const user = JSON.parse(localStorage.getItem('user') || '{}');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    // Redirect user ke dashboard user
    if (user.role === 'user') {
        window.location.href = '/dashboard';
        return;
    }

    try {
        // Get mentor profile
        const mentorResponse = await axios.get('/api/mentors', {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        // Find current user's mentor profile
        const myMentor = mentorResponse.data.find(m => m.user_id === user.id);

        if (!myMentor) {
            showProfileForm();
            return;
        }
        document.getElementById('profileCard').classList.add('hidden');

        currentMentorId = myMentor.id;

        // Get all bookings for this mentor
        const detail = await axios.get(`/api/mentors/${myMentor.uuid}`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        allBookings = detail.data.bookings || [];

        // Update stats
        document.getElementById('pendingCount').textContent =
            allBookings.filter(b => b.status === 'pending').length;
        document.getElementById('confirmedCount').textContent =
            allBookings.filter(b => b.status === 'confirmed').length;
        document.getElementById('completedCount').textContent =
            allBookings.filter(b => b.status === 'completed').length;

        const totalEarnings = allBookings
            .filter(b => ['confirmed', 'completed'].includes(b.status))
            .reduce((sum, b) => sum + parseFloat(b.total_price), 0);
        document.getElementById('totalEarnings').textContent = `Rp ${totalEarnings.toLocaleString('id-ID')}`;

        displayBookings(allBookings);
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Gagal memuat data booking');
    }
}

function displayBookings(bookings) {
    const bookingsList = document.getElementById('bookingsList');

    if (bookings.length === 0) {
        bookingsList.innerHTML = `
            <div class="text-center py-12">
                <span class="text-6xl">📚</span>
                <p class="text-gray-500 mt-4 text-lg">Belum ada booking</p>
            </div>
        `;
        return;
    }

    bookingsList.innerHTML = bookings.map(booking => `
        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="flex items-start gap-4 flex-1">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                        ${booking.user.name.charAt(0).toUpperCase()}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800">${booking.user.name}</h3>
                        <p class="text-sm text-gray-600">${booking.user.email}</p>

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
                                <p class="text-xs text-gray-500 mb-1">📝 Catatan dari siswa:</p>
                                <p class="text-sm text-gray-700">${booking.notes}</p>
                            </div>
                        ` : ''}
                    </div>
                </div>

                <div class="text-center md:text-right flex-shrink-0">
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-4 ${
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
                        <div class="space-y-2">
                            <button onclick="updateBookingStatus(${booking.id}, 'confirmed')"
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
                                ✓ Terima
                            </button>
                            <button onclick="updateBookingStatus(${booking.id}, 'cancelled')"
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition">
                                ✗ Tolak
                            </button>
                        </div>
                    ` : booking.status === 'confirmed' ? `
                        <button onclick="updateBookingStatus(${booking.id}, 'completed')"
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                            ✓ Selesai
                        </button>
                    ` : ''}
                </div>
            </div>
        </div>
    `).join('');
}

function filterBookings(status) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    event.target.classList.add('active', 'border-indigo-500', 'text-indigo-600');
    event.target.classList.remove('border-transparent', 'text-gray-500');

    let filtered = allBookings;
    if (status !== 'all') {
        filtered = allBookings.filter(b => b.status === status);
    }
    displayBookings(filtered);
}

async function updateBookingStatus(bookingId, newStatus) {
    const token = localStorage.getItem('auth_token');

    const confirmMsg = newStatus === 'confirmed' ?
        '✅ Terima booking ini?' :
        newStatus === 'completed' ?
        '✅ Tandai booking ini sebagai selesai?' :
        '⚠️ Tolak booking ini?';

    if (!confirm(confirmMsg)) {
        return;
    }

    showLoading('Memperbarui status booking...');

    try {
        const response = await axios.put(`/api/bookings/${bookingId}`,
            { status: newStatus },
            {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }
        );

        if (response.data) {
            alert(newStatus === 'confirmed' ?
                '✅ Booking berhasil dikonfirmasi!' :
                newStatus === 'completed' ?
                '✅ Booking selesai!' :
                '✗ Booking ditolak');
            loadMentorBookings();
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Gagal mengubah status booking');
    }
}

async function showProfileForm() {
    document.getElementById('profileCard').classList.remove('hidden');
    document.getElementById('bookingsList').innerHTML =
        '<p class="text-center text-gray-500 py-8">Buat profil mentor terlebih dahulu untuk melihat booking.</p>';

    const select = document.getElementById('pf_category');
    if (select.options.length > 1) return;

    try {
        const res = await axios.get('/api/categories');
        const cats = Array.isArray(res.data) ? res.data : (res.data.data || []);
        cats.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.name;
            select.appendChild(opt);
        });
    } catch (e) {
        console.error('Gagal memuat kategori:', e);
    }
}

document.getElementById('profileForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const token = localStorage.getItem('auth_token');
    const box = document.getElementById('profileMessage');
    box.classList.add('hidden');

    try {
        await axios.post('/api/mentors', {
            category_id: document.getElementById('pf_category').value,
            specialization: document.getElementById('pf_specialization').value,
            bio: document.getElementById('pf_bio').value,
            experience_years: document.getElementById('pf_experience').value,
            hourly_rate: document.getElementById('pf_rate').value,
            education: document.getElementById('pf_education').value
        }, { headers: { 'Authorization': `Bearer ${token}` } });

        document.getElementById('profileCard').classList.add('hidden');
        alert('✅ Profil mentor berhasil dibuat!');
        loadMentorBookings();
    } catch (error) {
        const data = error.response?.data;
        const first = data?.errors ? Object.values(data.errors)[0][0] : null;
        box.textContent = first || data?.error || data?.message || 'Gagal membuat profil mentor.';
        box.classList.remove('hidden');
    }
});

loadMentorBookings();
</script>
@endsection
