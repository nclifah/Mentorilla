@extends('layouts.app')

@section('title', 'Kategori - Mentorilla')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="/categories" class="inline-flex items-center text-white hover:text-indigo-100 mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Kategori
        </a>
        <h1 id="categoryName" class="text-4xl font-bold mb-2">Loading...</h1>
        <p id="categoryDesc" class="text-xl text-indigo-100"></p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <p class="text-gray-600"><span id="mentorCount" class="font-bold text-indigo-600">0</span> mentor tersedia</p>
    </div>

    <div id="mentorsList" class="grid md:grid-cols-3 gap-6">
        <div class="col-span-3 text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-200 border-t-indigo-600"></div>
            <p class="text-gray-500 mt-4">Memuat mentor...</p>
        </div>
    </div>
</div>

<script>
async function loadCategoryMentors() {
    const slug = '{{ $slug }}';

    try {
        const response = await axios.get(`/api/categories/${slug}`);
        const category = response.data;

        document.getElementById('categoryName').textContent = category.name;
        document.getElementById('categoryDesc').textContent = category.description || '';

        const mentors = category.mentors || [];
        document.getElementById('mentorCount').textContent = mentors.length;

        if (mentors.length === 0) {
            document.getElementById('mentorsList').innerHTML = `
                <div class="col-span-3 text-center py-12">
                    <span class="text-6xl">🔍</span>
                    <p class="text-gray-500 text-lg mt-4">Belum ada mentor di kategori ini</p>
                </div>
            `;
            return;
        }

        document.getElementById('mentorsList').innerHTML = mentors.map(mentor => `
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition card-hover">
                <div class="h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center relative">
                    <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center text-5xl font-bold text-indigo-600 border-4 border-white">
                        ${mentor.user.name.charAt(0).toUpperCase()}
                    </div>
                    <span class="absolute top-4 right-4 px-3 py-1 text-xs font-semibold rounded-full ${
                        mentor.status === 'available' ? 'bg-green-500 text-white' : 'bg-gray-500 text-white'
                    }">
                        ${mentor.status === 'available' ? '✓ Tersedia' : '✗ Tidak Aktif'}
                    </span>
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">${mentor.user.name}</h3>
                    <p class="text-sm text-gray-600 mb-4">${mentor.specialization}</p>

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
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('mentorsList').innerHTML =
            '<div class="col-span-3 text-center py-12"><p class="text-red-500">❌ Gagal memuat data</p></div>';
    }
}

loadCategoryMentors();
</script>
@endsection
