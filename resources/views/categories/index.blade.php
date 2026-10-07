@extends('layouts.app')

@section('title', 'Kategori - Mentorilla')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">📚 Kategori Pembelajaran</h1>
        <p class="text-xl text-indigo-100">Temukan mentor berdasarkan kategori yang Anda butuhkan</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div id="categoriesList" class="grid md:grid-cols-4 gap-6">
        <div class="col-span-4 text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-200 border-t-indigo-600"></div>
            <p class="text-gray-500 mt-4">Memuat kategori...</p>
        </div>
    </div>
</div>

<script>
async function loadCategories() {
    try {
        const response = await axios.get('/api/categories');
        const categories = response.data;

        document.getElementById('categoriesList').innerHTML = categories.map(cat => `
            <a href="/categories/${cat.slug}" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition card-hover border-l-4 ${
                cat.type === 'academic' ? 'border-blue-500' : 'border-purple-500'
            }">
                <div class="text-center">
                    <div class="${cat.type === 'academic' ? 'bg-blue-100' : 'bg-purple-100'} w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">${cat.type === 'academic' ? '📚' : '🎨'}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">${cat.name}</h3>
                    <p class="text-sm text-gray-600 mb-3">${cat.description || ''}</p>
                    <span class="inline-block px-4 py-1 text-sm rounded-full ${
                        cat.type === 'academic' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'
                    }">
                        ${cat.type === 'academic' ? 'Akademik' : 'Bakat'}
                    </span>
                </div>
            </a>
        `).join('');
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('categoriesList').innerHTML =
            '<div class="col-span-4 text-center py-12"><p class="text-red-500">❌ Gagal memuat kategori</p></div>';
    }
}

loadCategories();
</script>
@endsection
