<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mentorilla - Platform Guru Privat')</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Axios untuk API calls -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <span class="text-3xl">🎓</span>
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Mentorilla
                        </span>
                    </a>
                </div>

                <div class="flex items-center space-x-2">
                    <div class="hidden md:flex items-center space-x-1 mr-2">
                        <a href="/mentors" class="px-4 py-2 rounded-lg text-gray-700 hover:text-indigo-600 font-medium transition">
                            Cari Mentor
                        </a>
                        <a href="/categories" class="px-4 py-2 rounded-lg text-gray-700 hover:text-indigo-600 font-medium transition">
                            Kategori
                        </a>
                    </div>

                    <div id="authMenu" class="hidden">
                        <div class="flex items-center space-x-1">
                            <a id="navDashboard" href="/dashboard" class="px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium">
                                Dashboard
                            </a>
                            <a id="navBookings" href="/bookings" class="px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium">
                                Booking Saya
                            </a>
                            <button onclick="logout()" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium transition">
                                Logout
                            </button>
                        </div>
                    </div>

                    <div id="guestMenu" class="flex items-center space-x-2">
                        <a href="/login" class="px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium">
                            Login
                        </a>
                        <a href="/register" class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                            Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="text-3xl">🎓</span>
                        <span class="text-2xl font-bold">Mentorilla</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Platform terpercaya untuk mencari guru privat akademik dan bakat terbaik.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Menu</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/mentors" class="hover:text-white">Cari Mentor</a></li>
                        <li><a href="/categories" class="hover:text-white">Kategori</a></li>
                        <li><a href="/dashboard" class="hover:text-white">Dashboard</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>📧 info@mentorilla.com</li>
                        <li>📱 +62 812 3456 7890</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Mentorilla - Platform Pencarian Guru Privat Terbaik</p>
            </div>
        </div>
    </footer>

    <script>
        // Check auth status
        function getUser() {
            try {
                return JSON.parse(localStorage.getItem('user') || '{}');
            } catch (e) {
                return {};
            }
        }

        function checkAuth() {
            const token = localStorage.getItem('auth_token');
            if (token) {
                document.getElementById('authMenu').classList.remove('hidden');
                document.getElementById('guestMenu').classList.add('hidden');

                // Menu menyesuaikan role: mentor ke dashboard mentor, tanpa "Booking Saya"
                const isMentor = getUser().role === 'mentor';
                document.getElementById('navDashboard').href = isMentor ? '/dashboard/mentor' : '/dashboard';
                document.getElementById('navBookings').classList.toggle('hidden', isMentor);
            } else {
                document.getElementById('authMenu').classList.add('hidden');
                document.getElementById('guestMenu').classList.remove('hidden');
            }
        }

        function logout() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');
            alert('Anda telah logout');
            window.location.href = '/';
        }

        checkAuth();
    </script>
</body>
</html>
