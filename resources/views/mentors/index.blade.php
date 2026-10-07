@extends('layouts.app')

@section('title', 'Cari Mentor - Mentorilla')

@section('content')
<!-- Header Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Temukan Mentor Terbaik</h1>
        <p class="text-xl text-indigo-100">Pilih dari ratusan mentor berkualitas sesuai kebutuhan Anda</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 mb-12">
    <!-- Search & Filter Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="grid md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">🔍 Cari Mentor</label>
                <input type="text" id="searchInput" placeholder="Nama atau spesialisasi..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">📚 Kategori</label>
                <select id="categoryFilter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">✅ Status</label>
                <select id="statusFilter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="available">Tersedia</option>
                    <option value="busy">Sibuk</option>
                </select>
            </div>
        </div>
        <button onclick="applyFilters()" class="mt-4 w-full md:w-auto px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
            Terapkan Filter
        </button>
    </div>

    <!-- Results Count -->
    <div class="mb-4">
        <p class="text-gray-600"><span id="mentorCount" class="font-bold text-indigo-600">0</span> mentor ditemukan</p>
    </div>

    <!-- Mentors Grid -->
    <div id="mentorsList" class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="col-span-3 text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-200 border-t-indigo-600"></div>
            <p class="text-gray-500 mt-4">Memuat mentor...</p>
        </div>
    </div>
</div>

<script>
let allMentors = [];

async function loadMentors() {
    try {
        const response = await axios.get('/api/mentors');
        allMentors = response.data;
        displayMentors(allMentors);

        const catResponse = await axios.get('/api/categories');
        const categories = catResponse.data;
        const categorySelect = document.getElementById('categoryFilter');
        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.id;
            option.textContent = cat.name;
            categorySelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('mentorsList').innerHTML =
            '<div class="col-span-3 text-center py-12"><p class="text-red-500">❌ Gagal memuat mentor</p></div>';
    }
}

function displayMentors(mentors) {
    const mentorsList = document.getElementById('mentorsList');
    document.getElementById('mentorCount').textContent = mentors.length;

    if (mentors.length === 0) {
        mentorsList.innerHTML = `
            <div class="col-span-3 text-center py-12">
                <span class="text-6xl">🔍</span>
                <p class="text-gray-500 text-lg mt-4">Tidak ada mentor ditemukan</p>
            </div>
        `;
        return;
    }

    mentorsList.innerHTML = mentors.map(mentor => `
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition card-hover">
            <!-- Avatar Section -->
            <div class="h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center relative">
                ${mentor.photo ?
                    `<img src="${mentor.photo}" alt="${mentor.user.name}" class="w-32 h-32 rounded-full border-4 border-white object-cover">` :
                    `<div class="w-32 h-32 rounded-full bg-white flex items-center justify-center text-5xl font-bold text-indigo-600 border-4 border-white">
                        ${mentor.user.name.charAt(0).toUpperCase()}
                    </div>`
                }
                <span class="absolute top-4 right-4 px-3 py-1 text-xs font-semibold rounded-full ${
                    mentor.status === 'available' ? 'bg-green-500 text-white' :
                    mentor.status === 'busy' ? 'bg-yellow-500 text-white' :
                    'bg-gray-500 text-white'
                }">
                    ${mentor.status === 'available' ? '✓ Tersedia' :
                      mentor.status === 'busy' ? '⏰ Sibuk' : '✗ Tidak Aktif'}
                </span>
            </div>

            <!-- Info Section -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-1">${mentor.user.name}</h3>
                <p class="text-sm text-indigo-600 font-semibold mb-2">${mentor.category.name}</p>
                <p class="text-sm text-gray-600 mb-4">${mentor.specialization}</p>
                <p class="text-sm text-gray-700 mb-4 line-clamp-2">${mentor.bio}</p>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-2 mb-4 text-center">
                    <div class="bg-blue-50 rounded-lg p-2">
                        <p class="text-xs text-gray-600">Rating</p>
                        <p class="font-bold text-blue-600">⭐ ${mentor.rating}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-2">
                        <p class="text-xs text-gray-600">Siswa</p>
                        <p class="font-bold text-green-600">👥 ${mentor.total_students}</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-2">
                        <p class="text-xs text-gray-600">Exp</p>
                        <p class="font-bold text-purple-600">📚 ${mentor.experience_years}th</p>
                    </div>
                </div>

                <!-- Price & Action -->
                <div class="flex items-center justify-between border-t pt-4">
                    <div>
                        <p class="text-2xl font-bold text-indigo-600">Rp ${parseFloat(mentor.hourly_rate).toLocaleString('id-ID')}</p>
                        <p class="text-xs text-gray-500">per jam</p>
                    </div>
                    <a href="/mentors/${mentor.uuid}" class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    `).join('');
}

function applyFilters() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const category = document.getElementById('categoryFilter').value;
    const status = document.getElementById('statusFilter').value;

    let filtered = allMentors;

    if (search) {
        filtered = filtered.filter(m =>
            m.user.name.toLowerCase().includes(search) ||
            m.specialization.toLowerCase().includes(search)
        );
    }

    if (category) {
        filtered = filtered.filter(m => m.category_id == category);
    }

    if (status) {
        filtered = filtered.filter(m => m.status === status);
    }

    displayMentors(filtered);
}

document.getElementById('searchInput').addEventListener('input', applyFilters);

loadMentors();
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
