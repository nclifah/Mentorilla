@extends('layouts.app')

@section('title', 'Detail Mentor - Mentorilla')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <a href="/mentors" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Daftar Mentor
    </a>

    <div id="mentorDetail">
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-200 border-t-indigo-600"></div>
            <p class="text-gray-500 mt-4">Memuat detail mentor...</p>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-2xl font-bold text-gray-800">📅 Booking Mentor</h3>
            <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="bookingForm" class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">📅 Tanggal</label>
                <input type="date" id="bookingDate" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">🕐 Waktu Mulai</label>
                <input type="time" id="startTime" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">⏱️ Durasi</label>
                <select id="duration" required onchange="updateTotalPrice()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="1">1 Jam</option>
                    <option value="2">2 Jam</option>
                    <option value="3">3 Jam</option>
                    <option value="4">4 Jam</option>
                    <option value="5">5 Jam</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">📝 Catatan (Opsional)</label>
                <textarea id="notes" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                          placeholder="Materi yang ingin dipelajari..."></textarea>
            </div>

            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-lg mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-700">Tarif per jam:</span>
                    <span id="hourlyRate" class="font-semibold">Rp 0</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-700">Durasi:</span>
                    <span id="durationText" class="font-semibold">1 jam</span>
                </div>
                <div class="border-t border-indigo-200 pt-2 mt-2">
                    <div class="flex justify-between text-lg font-bold">
                        <span class="text-gray-800">Total:</span>
                        <span id="totalPrice" class="text-indigo-600">Rp 0</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition">
                ✓ Konfirmasi Booking
            </button>
        </form>
    </div>
</div>

<script>
let currentMentor = null;

async function loadMentorDetail() {
    const uuid = '{{ $uuid }}';

    try {
        const response = await axios.get(`/api/mentors/${uuid}`);
        currentMentor = response.data;
        displayMentorDetail(currentMentor);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('mentorDetail').innerHTML =
            '<div class="text-center py-12"><p class="text-red-500 text-lg">❌ Gagal memuat detail mentor</p></div>';
    }
}

function displayMentorDetail(mentor) {
    document.getElementById('mentorDetail').innerHTML = `
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-8">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    ${mentor.photo ?
                        `<img src="${mentor.photo}" alt="${mentor.user.name}" class="w-40 h-40 rounded-full border-4 border-white object-cover">` :
                        `<div class="w-40 h-40 rounded-full bg-white flex items-center justify-center text-6xl font-bold text-indigo-600 border-4 border-white">
                            ${mentor.user.name.charAt(0).toUpperCase()}
                        </div>`
                    }
                    <div class="text-white text-center md:text-left">
                        <h1 class="text-4xl font-bold mb-2">${mentor.user.name}</h1>
                        <p class="text-xl mb-3">${mentor.specialization}</p>
                        <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                            <span class="bg-white bg-opacity-20 px-4 py-1 rounded-full text-sm">${mentor.category.name}</span>
                            <span class="px-4 py-1 rounded-full text-sm ${
                                mentor.status === 'available' ? 'bg-green-500' :
                                mentor.status === 'busy' ? 'bg-yellow-500' : 'bg-gray-500'
                            }">
                                ${mentor.status === 'available' ? '✓ Tersedia' :
                                  mentor.status === 'busy' ? '⏰ Sibuk' : '✗ Tidak Aktif'}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Left Column -->
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <h2 class="text-2xl font-bold mb-3 text-gray-800">📖 Tentang Mentor</h2>
                            <p class="text-gray-700 leading-relaxed">${mentor.bio}</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold mb-3 text-gray-800">🎓 Pendidikan</h2>
                            <p class="text-gray-700">${mentor.education}</p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold mb-3 text-gray-800">💼 Pengalaman</h2>
                            <p class="text-gray-700">${mentor.experience_years} tahun mengajar di bidang ${mentor.category.name}</p>
                        </div>

                        <!-- Stats Cards -->
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <p class="text-3xl font-bold text-blue-600">⭐ ${mentor.rating}</p>
                                <p class="text-sm text-gray-600 mt-1">Rating</p>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 text-center">
                                <p class="text-3xl font-bold text-green-600">👥 ${mentor.total_students}</p>
                                <p class="text-sm text-gray-600 mt-1">Total Siswa</p>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-4 text-center">
                                <p class="text-3xl font-bold text-purple-600">📚 ${mentor.experience_years}</p>
                                <p class="text-sm text-gray-600 mt-1">Tahun</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Booking Card -->
                    <div>
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-6 sticky top-4 shadow-lg border border-indigo-100">
                            <div class="text-center mb-6">
                                <p class="text-4xl font-bold text-indigo-600 mb-2">
                                    Rp ${parseFloat(mentor.hourly_rate).toLocaleString('id-ID')}
                                </p>
                                <p class="text-gray-600">per jam</p>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex items-center justify-between py-2 border-b border-indigo-200">
                                    <span class="text-gray-700">⭐ Rating:</span>
                                    <span class="font-semibold text-gray-800">${mentor.rating}/5.0</span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-indigo-200">
                                    <span class="text-gray-700">👥 Total Siswa:</span>
                                    <span class="font-semibold text-gray-800">${mentor.total_students} orang</span>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-700">📚 Pengalaman:</span>
                                    <span class="font-semibold text-gray-800">${mentor.experience_years} tahun</span>
                                </div>
                            </div>

                            ${mentor.status === 'available' ? `
                                <button onclick="openBookingModal()"
                                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-semibold text-lg hover:shadow-lg transition">
                                    📅 Booking Sekarang
                                </button>
                                <p class="text-center text-xs text-gray-500 mt-3">
                                    ✓ Booking akan dikonfirmasi dalam 24 jam
                                </p>
                            ` : `
                                <button disabled
                                        class="w-full bg-gray-400 text-white py-3 rounded-lg cursor-not-allowed font-semibold text-lg">
                                    ✗ Mentor Tidak Tersedia
                                </button>
                                <p class="text-center text-xs text-gray-500 mt-3">
                                    Mentor sedang tidak menerima booking
                                </p>
                            `}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function openBookingModal() {
    const token = localStorage.getItem('auth_token');
    if (!token) {
        alert('⚠️ Silakan login terlebih dahulu');
        window.location.href = '/login';
        return;
    }

    document.getElementById('bookingModal').classList.remove('hidden');

    const today = new Date().toISOString().split('T')[0];
    document.getElementById('bookingDate').setAttribute('min', today);

    updateTotalPrice();
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.add('hidden');
}

function updateTotalPrice() {
    const duration = parseInt(document.getElementById('duration').value) || 1;
    const hourlyRate = parseFloat(currentMentor.hourly_rate);
    const total = hourlyRate * duration;

    document.getElementById('hourlyRate').textContent = `Rp ${hourlyRate.toLocaleString('id-ID')}`;
    document.getElementById('durationText').textContent = `${duration} jam`;
    document.getElementById('totalPrice').textContent = `Rp ${total.toLocaleString('id-ID')}`;
}

document.getElementById('bookingForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const token = localStorage.getItem('auth_token');
    const data = {
        mentor_id: currentMentor.id,
        booking_date: document.getElementById('bookingDate').value,
        start_time: document.getElementById('startTime').value,
        duration_hours: parseInt(document.getElementById('duration').value),
        notes: document.getElementById('notes').value
    };

    try {
        const response = await axios.post('/api/bookings', data, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        if (response.data) {
            alert('✅ Booking berhasil! Menunggu konfirmasi mentor.');
            closeBookingModal();
            window.location.href = '/bookings';
        }
    } catch (error) {
        console.error('Error:', error);
        const errors = error.response?.data?.errors;
        if (errors) {
            let errorMsg = '';
            for (let key in errors) {
                errorMsg += errors[key].join('\n') + '\n';
            }
            alert('❌ ' + errorMsg);
        } else {
            alert('❌ Booking gagal! Silakan coba lagi.');
        }
    }
});

loadMentorDetail();
</script>
@endsection
