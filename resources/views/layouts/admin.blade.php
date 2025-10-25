<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi STAI RAYA - Administrator">
    <title>@yield('title', 'Admin SI-RAYA STAI RAYA')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Styles -->
    <style>
        /* Variabel warna untuk tema terang */
        :root {
            --primary-green: #2C5E1A;
            --secondary-green: #4A7C59;
            --background-light: #F8FAFC;
            --text-dark: #1A202C;
            --sidebar-background: #2c3e50;
            --sidebar-text: white;
            --card-background: white;
            --card-border: #e5e7eb;
            --input-background: white;
            --input-border: #d1d5db;
            --text-muted: #6b7280;
            --sidebar-width: 250px;
            --sidebar-width-mobile: 250px;
            --sidebar-width-compact: 80px;
        }

        /* Variabel warna untuk tema gelap */
        :root.dark-mode {
            --primary-green: #3d8b3d;
            --secondary-green: #5c9e6f;
            --background-light: #121212;
            --text-dark: #e0e0e0;
            --sidebar-background: #1f2937;
            --sidebar-text: #e0e0e0;
            --card-background: #1e293b;
            --card-border: #374151;
            --input-background: #374151;
            --input-border: #4b5563;
            --text-muted: #9ca3af;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--background-light);
            color: var(--text-dark);
            line-height: 1.6;
            transition: background-color 0.3s, color 0.3s;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-background);
            color: var(--sidebar-text);
            padding: 20px 0;
            transition: width 0.3s ease, background-color 0.3s, color 0.3s;
            overflow-x: hidden;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu-group {
            margin-bottom: 0;
        }

        .sidebar-menu-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            user-select: none;
            background-color: transparent;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .sidebar-menu-title:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            background-color: rgba(0,0,0,0.2);
            transition: max-height 0.3s ease-in-out;
        }

        .sidebar-submenu.show {
            max-height: 500px;
        }

        .sidebar-submenu-content {
            padding: 5px 0;
        }

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px 12px 40px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .sidebar-menu-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-menu-item.active {
            background-color: rgba(255,255,255,0.2);
            border-left: 4px solid var(--primary-green);
            color: white;
        }

        .sidebar-menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease, background-color 0.3s;
            background-color: var(--background-light);
        }

        .sidebar-search {
            padding: 10px 20px;
            margin-bottom: 15px;
        }

        .sidebar-search-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid rgba(255,255,255,0.2);
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        .sidebar-search-input:focus {
            outline: none;
            border-color: var(--primary-green);
        }

        .sidebar-search-input::placeholder {
            color: rgba(255,255,255,0.5);
        }

        .sidebar-menu-item.hidden {
            display: none;
        }

        .theme-toggle {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: none;
            border: none;
            color: var(--sidebar-text);
            cursor: pointer;
            font-size: 20px;
            transition: transform 0.3s ease, color 0.3s, background-color 0.3s;
            padding: 10px;
            border-radius: 50%;
        }

        .theme-toggle:hover {
            transform: rotate(180deg);
            background-color: rgba(255,255,255,0.1);
        }

        /* Mode Terang */
        :root {
            --theme-toggle-light-bg: #e0e0e0;
            --theme-toggle-light-color: #2c3e50;
            --theme-toggle-dark-bg: rgba(255,255,255,0.2);
            --theme-toggle-dark-color: #ffd700;
        }

        /* Mode Gelap */
        :root.dark-mode .theme-toggle {
            color: var(--theme-toggle-dark-color);
            background-color: var(--theme-toggle-dark-bg);
        }

        /* Mode Terang */
        :root:not(.dark-mode) .theme-toggle {
            color: var(--theme-toggle-light-color);
            background-color: var(--theme-toggle-light-bg);
        }

        /* Animasi transisi */
        .theme-toggle i {
            transition: transform 0.3s ease;
        }

        :root.dark-mode .theme-toggle i {
            transform: rotate(180deg);
        }

        /* Mobile Sidebar Toggle */
        .mobile-sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
            background: var(--secondary-green);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .mobile-sidebar-toggle i {
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .mobile-sidebar-toggle {
                display: block;
            }

            .sidebar {
                width: var(--sidebar-width-mobile);
                max-width: var(--sidebar-width-mobile);
                min-width: var(--sidebar-width-mobile);
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1000;
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                overflow-y: auto;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .sidebar {
                width: var(--sidebar-width-compact);
                max-width: var(--sidebar-width-compact);
                min-width: var(--sidebar-width-compact);
                overflow: hidden;
            }

            .main-content {
                margin-left: var(--sidebar-width-compact);
                width: calc(100% - var(--sidebar-width-compact));
            }

            .sidebar-header h2 {
                display: none;
            }

            .sidebar-menu-item span {
                display: none;
            }

            .sidebar-menu-item i {
                margin-right: 0;
            }

            .sidebar-menu-title span {
                display: none;
            }

            .sidebar-menu-title .toggle-icon {
                margin-left: auto;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="app-container">
        <!-- Tombol Hamburger untuk Mobile -->
        <button class="mobile-sidebar-toggle" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>

        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/stai-raya-logo.png') }}" alt="STAI RAYA Logo">
                <h2>Admin SI-RAYA</h2>
            </div>

            <div class="sidebar-search">
                <input type="text" class="sidebar-search-input" placeholder="Cari menu..." id="sidebar-search">
            </div>

            <nav>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-group">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-menu-item="dashboard">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>

                    <li class="sidebar-menu-title" data-toggle="user-management">
                        <span>Manajemen Pengguna</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </li>
                    <li>
                        <div class="sidebar-submenu" id="user-management">
                            <div class="sidebar-submenu-content">
                                <a href="{{ route('admin.manajemen-user.index') }}" class="sidebar-menu-item" data-menu-item="user-management">
                                    <i class="fas fa-users"></i> Manajemen User
                                </a>
                            </div>
                        </div>
                    </li>

                    <li class="sidebar-menu-title" data-toggle="location-management">
                        <span>Manajemen Lokasi</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </li>
                    <li>
                        <div class="sidebar-submenu" id="location-management">
    <div class="sidebar-submenu-content">
        <a href="{{ route('admin.lokasi.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.lokasi.*') ? 'active' : '' }}" data-menu-item="location-management">
            <i class="fas fa-map-marker-alt"></i> Pengaturan Lokasi
        </a>
    </div>
</div>
                    </li>
                    <li class="sidebar-menu-title" data-toggle="academic-management">
    <span>Manajemen Akademik</span>
    <i class="fas fa-chevron-down toggle-icon"></i>
</li>
<li>
    <div class="sidebar-submenu" id="academic-management">
        <div class="sidebar-submenu-content">
            <a href="{{ route('admin.manajemen-prodi.index') }}" 
               class="sidebar-menu-item" 
               data-menu-item="academic-prodi">
                <i class="fas fa-university"></i> Manajemen Prodi
            </a>
            <a href="{{ route('admin.manajemen-mata-kuliah.index') }}" 
               class="sidebar-menu-item" 
               data-menu-item="academic-mata-kuliah">
                <i class="fas fa-book"></i> Manajemen Mata Kuliah
            </a>
        </div>
    </div>
</li>
                    <li class="sidebar-menu-title" data-toggle="lecturer-management">
                        <span>Manajemen Dosen</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </li>
                    <li>
                        <div class="sidebar-submenu" id="lecturer-management">
                            <div class="sidebar-submenu-content">
                                <a href="{{ route('admin.manajemen-presensi-dosen.index') }}" class="sidebar-menu-item" data-menu-item="lecturer-absen">
                        <i class="fas fa-calendar-check"></i> Manajemen Presensi Dosen
                        </a>

                            </div>
                        </div>
                    </li>

                    <li class="sidebar-menu-title" data-toggle="student-management">
                        <span>Manajemen Mahasiswa</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </li>
                    <li>
                        <div class="sidebar-submenu" id="student-management">
                            <div class="sidebar-submenu-content">
                                <a href="{{ route('admin.manajemen-presensi-mahasiswa.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.manajemen-presensi-mahasiswa.*') ? 'active' : '' }}" data-menu-item="student-absen">
                                    <i class="fas fa-calendar-alt"></i> Manajemen Presensi Mahasiswa
                                </a>
                                <a href="{{ route('admin.manajemen-nilai-mahasiswa.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.manajemen-nilai-mahasiswa.*') ? 'active' : '' }}" data-menu-item="student-grades">
                                    <i class="fas fa-chart-bar"></i> Manajemen Nilai Mahasiswa
                                </a>
                                <a href="{{ route('admin.jadwal-mahasiswa.index') }}"class="sidebar-menu-item {{ request()->routeIs('admin.jadwal-mahasiswa.*') ? 'active' : '' }}"data-menu-item="student-schedule">
                                    <i class="fas fa-calendar-week"></i> Jadwal Mahasiswa
                                </a>
                                <a href="{{ route('admin.khs.index') }}" class="sidebar-menu-item" data-menu-item="student-khs">
                                    <i class="fas fa-file-alt"></i> KHS Mahasiswa
                                </a>
                                <a href="{{ route('admin.krs.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.krs.*') ? 'active' : '' }}" data-menu-item="student-krs">
                                    <i class="fas fa-file-alt"></i> KRS Mahasiswa
                                </a>
                                <a href="{{ route('admin.blokir-mahasiswa.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.blokir-mahasiswa.*') ? 'active' : '' }}" data-menu-item="student-block">
                                    <i class="fas fa-user-lock"></i> Pemblokiran Mahasiswa
                                </a>
                            </div>
                        </div>
                    </li>

                    <li class="sidebar-menu-title">
                        <span>Pengaturan</span>
                    </li>
                    <li class="sidebar-menu-group">
                        <a href="{{ route('logout') }}" class="sidebar-menu-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>

            <button class="theme-toggle" aria-label="Toggle Theme">
                <i class="fas fa-adjust"></i>
            </button>
        </aside>

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle dropdown menu
            const menuTitles = document.querySelectorAll('.sidebar-menu-title[data-toggle]');
            
            menuTitles.forEach(function(title) {
                title.addEventListener('click', function() {
                    const toggleId = this.getAttribute('data-toggle');
                    const submenu = document.getElementById(toggleId);
                    
                    if (submenu) {
                        // Toggle class show
                        const isOpen = submenu.classList.contains('show');
                        
                        // Tutup semua submenu
                        document.querySelectorAll('.sidebar-submenu').forEach(function(sub) {
                            sub.classList.remove('show');
                        });
                        
                        // Hapus active dari semua title
                        document.querySelectorAll('.sidebar-menu-title').forEach(function(t) {
                            t.classList.remove('active');
                        });
                        
                        // Buka submenu yang diklik jika sebelumnya tertutup
                        if (!isOpen) {
                            submenu.classList.add('show');
                            this.classList.add('active');
                        }
                    }
                });
            });

            // Search functionality
            const searchInput = document.getElementById('sidebar-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const menuItems = document.querySelectorAll('.sidebar-menu-item');
                    
                    menuItems.forEach(function(item) {
                        const text = item.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            item.classList.remove('hidden');
                            // Tampilkan parent submenu jika ada
                            const parentSubmenu = item.closest('.sidebar-submenu');
                            if (parentSubmenu) {
                                parentSubmenu.classList.add('show');
                            }
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });
            }

            // Mobile Sidebar Toggle
            const mobileSidebarToggle = document.querySelector('.mobile-sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');

            if (mobileSidebarToggle && sidebar) {
                mobileSidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768 && 
                    sidebar.classList.contains('show') && 
                    !sidebar.contains(event.target) && 
                    !mobileSidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            });

            // Theme Toggle
            const themeToggle = document.querySelector('.theme-toggle');
            const htmlRoot = document.documentElement;

            // Fungsi untuk mengatur tema
            function setTheme(theme) {
                if (theme === 'dark') {
                    htmlRoot.classList.add('dark-mode');
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i>'; // Ikon bulan untuk mode gelap
                    localStorage.setItem('theme', 'dark');
                } else {
                    htmlRoot.classList.remove('dark-mode');
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>'; // Ikon matahari untuk mode terang
                    localStorage.setItem('theme', 'light');
                }
            }

            // Cek tema yang tersimpan di localStorage
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                setTheme(savedTheme);
            } else {
                // Default ke mode terang jika belum ada preferensi
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }

            // Toggle tema saat tombol diklik
            themeToggle.addEventListener('click', function() {
                const currentTheme = htmlRoot.classList.contains('dark-mode') ? 'dark' : 'light';
                setTheme(currentTheme === 'light' ? 'dark' : 'light');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
