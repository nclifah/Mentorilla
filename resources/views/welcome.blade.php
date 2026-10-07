@extends('layouts.app')

@section('title', 'Mentorilla - Temukan Guru Privat Terbaik')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-6">Temukan Guru Privat Terbaik</h1>
        <p class="text-xl mb-8">Platform terpercaya untuk belajar akademik dan mengembangkan bakat</p>
        <div class="flex justify-center space-x-4">
            <a href="/mentors" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                Cari Mentor Sekarang
            </a>
            <a href="/register" class="bg-transparent border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600">
                Daftar Sebagai Mentor
            </a>
        </div>
    </div>
</div>

<!-- Features -->
<div class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Mengapa Memilih Mentorilla?</h2>
    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">📚</span>
            </div>
            <h3 class="text-xl font-semibold mb-2">Mentor Berkualitas</h3>
            <p class="text-gray-600">Semua mentor telah terverifikasi dan berpengalaman</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">⏰</span>
            </div>
            <h3 class="text-xl font-semibold mb-2">Jadwal Fleksibel</h3>
            <p class="text-gray-600">Pilih waktu belajar sesuai kenyamanan Anda</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">💰</span>
            </div>
            <h3 class="text-xl font-semibold mb-2">Harga Transparan</h3>
            <p class="text-gray-600">Lihat tarif mentor dan booking langsung</p>
        </div>
    </div>
</div>

<!-- Categories -->
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Kategori Populer</h2>
        <div class="grid md:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <a href="/categories/{{ $category->slug }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                <h3 class="font-semibold text-lg mb-2">{{ $category->name }}</h3>
                <span class="inline-block px-3 py-1 text-sm rounded-full {{ $category->type == 'academic' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                    {{ $category->type == 'academic' ? 'Akademik' : 'Bakat' }}
                </span>
            </a>
            @endforeach
        </div>
    </div>
</div>

<!-- CTA -->
<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="bg-indigo-600 rounded-2xl p-12 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Siap Mulai Belajar?</h2>
        <p class="text-xl mb-8">Temukan mentor yang tepat untuk mencapai tujuan Anda</p>
        <a href="/mentors" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 inline-block">
            Lihat Semua Mentor
        </a>
    </div>
</div>
@endsection
