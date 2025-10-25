<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi STAI RAYA - Dashboard Dosen">
    <title><?php echo $__env->yieldContent('title', 'Dosen SI-RAYA STAI RAYA'); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #0B6623;
            --primary-dark: #084d1a;
            --primary-light: #e8f5ec;
            --accent: #D4AF37;
            --accent-light: #f5efd3;
            --hover: #198754;
            --background: #f5f7fa;
            --surface: #ffffff;
            --text-primary: #1a202c;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --radius: 12px;
            --radius-lg: 16px;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--background);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Form Elements */
        .form-select {
            display: block;
            width: 100%;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.5;
            color: var(--text-primary);
            background-color: var(--surface);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            transition: var(--transition);
            appearance: none;
        }

        .form-select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .form-select:hover {
            border-color: var(--primary);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1.5;
            border-radius: var(--radius);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 1px 2px 0 rgba(11, 102, 35, 0.05);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            box-shadow: 0 4px 6px -1px rgba(11, 102, 35, 0.15);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-info {
            background-color: var(--accent);
            color: var(--primary-dark);
            box-shadow: 0 1px 2px 0 rgba(212, 175, 55, 0.05);
        }

        .btn-info:hover {
            background-color: #c19d2f;
            box-shadow: 0 4px 6px -1px rgba(212, 175, 55, 0.15);
            transform: translateY(-1px);
        }

        .btn[disabled] {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Cards */
        .card {
            background-color: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            background-color: var(--surface);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.025em;
        }

        /* Utilities */
        .container-fluid {
            width: 100%;
            padding-right: 1rem;
            padding-left: 1rem;
            margin-right: auto;
            margin-left: auto;
        }

        .mb-4 { margin-bottom: 1.5rem; }
        .mt-4 { margin-top: 1.5rem; }
        .me-2 { margin-right: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -0.75rem;
            margin-left: -0.75rem;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 0.75rem;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 0.75rem;
        }

        .col-md-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
            padding: 0 0.75rem;
        }

        .col-lg-3 {
            flex: 0 0 25%;
            max-width: 25%;
            padding: 0 0.75rem;
        }

        /* Top Navigation Bar */
        .top-navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .navbar-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 64px;
        }

        /* Logo Section */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 1.125rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .navbar-brand:hover .brand-logo {
            transform: scale(1.05);
        }

        .brand-text h1 {
            font-size: 1.125rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.025em;
            margin-bottom: 2px;
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 0.6875rem;
            color: var(--accent);
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        /* Navigation Menu */
        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 0.125rem;
            flex: 1;
            justify-content: center;
            padding: 0 1rem;
            max-width: 700px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 0.875rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.8125rem;
            font-weight: 600;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
            white-space: nowrap;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 2px;
            background: var(--accent);
            border-radius: 2px 2px 0 0;
        }

        .nav-link i {
            font-size: 1rem;
        }

        /* Dropdown Menu */
        .nav-dropdown {
            position: relative;
        }

        .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 0.875rem;
            color: rgba(255, 255, 255, 0.8);
            background: none;
            border: none;
            font-size: 0.8125rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-family: inherit;
            white-space: nowrap;
        }

        .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .dropdown-toggle i.fa-chevron-down {
            font-size: 0.625rem;
            transition: transform 0.2s ease;
        }

        .nav-dropdown.active .dropdown-toggle {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .nav-dropdown.active .dropdown-toggle i.fa-chevron-down {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 12px);
            left: 50%;
            transform: translateX(-50%) translateY(-10px);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-xl);
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            overflow: hidden;
        }

        .nav-dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.875rem 1.25rem;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: var(--transition);
            border-bottom: 1px solid var(--border);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .dropdown-item:hover i {
            color: var(--primary);
        }

        /* User Section */
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.375rem 0.875rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: var(--transition);
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-dark);
            font-weight: 800;
            font-size: 0.8125rem;
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
            flex-shrink: 0;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .user-name {
            font-size: 0.8125rem;
            font-weight: 700;
            color: white;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }

        .user-role {
            font-size: 0.6875rem;
            color: var(--accent);
            font-weight: 600;
            white-space: nowrap;
        }

        /* Logout Button */
        .logout-btn {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 0.4375rem 1rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.25);
            color: #fee2e2;
            border-color: rgba(239, 68, 68, 0.5);
            transform: translateY(-1px);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        /* Statistik Boxes */
        .small-box {
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            color: white;
            transition: var(--transition);
        }

        .small-box:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .small-box .inner {
            position: relative;
            z-index: 2;
        }

        .small-box h3 {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0 0 0.25rem 0;
            letter-spacing: -0.025em;
        }

        .small-box p {
            font-size: 0.875rem;
            margin: 0;
            font-weight: 600;
            opacity: 0.9;
        }

        .small-box .icon {
            position: absolute;
            top: 50%;
            right: 1.5rem;
            transform: translateY(-50%);
            font-size: 4rem;
            opacity: 0.2;
            z-index: 1;
        }

        .bg-success { background: linear-gradient(135deg, #28a745 0%, #20843b 100%); }
        .bg-warning { 
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #212529 !important;
        }
        .bg-info { background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); }
        .bg-danger { background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%); }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            color: white;
            font-size: 1.125rem;
            cursor: pointer;
            transition: var(--transition);
            align-items: center;
            justify-content: center;
        }

        .mobile-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 64px;
            left: 0;
            width: 100%;
            height: calc(100vh - 64px);
            background: var(--surface);
            z-index: 999;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-xl);
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        .mobile-nav-section {
            border-bottom: 1px solid var(--border);
        }

        .mobile-nav-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1.25rem 1.5rem 0.75rem;
        }

        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem 1.5rem;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .mobile-nav-link:hover,
        .mobile-nav-link.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .mobile-nav-link i {
            width: 24px;
            text-align: center;
            font-size: 1.125rem;
            color: var(--text-secondary);
        }

        .mobile-nav-link:hover i,
        .mobile-nav-link.active i {
            color: var(--primary);
        }

        /* Main Content */
        .main-content {
            max-width: 1440px;
            margin: 0 auto;
            padding: 2rem;
            min-height: calc(100vh - 64px - 80px);
        }

        /* Breadcrumb */
        .breadcrumb-container {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow-sm);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            font-size: 0.875rem;
            flex-wrap: wrap;
        }

        .breadcrumb-item {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .breadcrumb-item:hover {
            color: var(--primary);
        }

        .breadcrumb-item.active {
            color: var(--primary);
        }

        .breadcrumb i.fa-chevron-right {
            font-size: 0.625rem;
            color: var(--text-secondary);
        }

        .breadcrumb i.fa-home {
            font-size: 1rem;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--hover) 100%);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
            position: relative;
            z-index: 2;
        }

        .page-header p {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }

        /* Footer */
        .footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 2rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
        }

        .footer-link {
            font-size: 0.875rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .footer-link:hover {
            color: var(--primary);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .navbar-menu {
                gap: 0.125rem;
                padding: 0 0.5rem;
            }

            .nav-link,
            .dropdown-toggle {
                padding: 0.5rem 0.75rem;
                font-size: 0.8125rem;
            }
            
            .nav-link span,
            .dropdown-toggle span {
                display: none;
            }
            
            .nav-link i,
            .dropdown-toggle i:not(.fa-chevron-down) {
                font-size: 1.125rem;
            }
        }

        @media (max-width: 1024px) {
            .navbar-menu {
                display: none;
            }

            .mobile-toggle {
                display: flex;
            }

            .mobile-menu {
                display: block;
            }

            .user-details {
                display: none;
            }

            .user-info {
                padding: 0.375rem;
            }

            .logout-btn span {
                display: none;
            }

            .logout-btn {
                padding: 0.4375rem;
            }

            .col-lg-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                padding: 0 1rem;
                height: 64px;
            }

            .mobile-menu {
                top: 64px;
                height: calc(100vh - 64px);
            }

            .brand-logo {
                width: 38px;
                height: 38px;
                font-size: 1.125rem;
            }

            .brand-text h1 {
                font-size: 1.125rem;
            }

            .brand-text p {
                display: none;
            }

            .main-content {
                padding: 1.5rem 1rem;
            }

            .page-header {
                padding: 2rem 1.5rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .page-header p {
                font-size: 0.875rem;
            }

            .breadcrumb-container {
                padding: 0.875rem 1rem;
            }

            .footer {
                padding: 1.5rem 1rem;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .footer-links {
                gap: 1.5rem;
            }

            .col-6,
            .col-lg-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .col-md-4,
            .col-md-8 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .small-box {
                padding: 1.25rem;
            }

            .small-box h3 {
                font-size: 1.875rem;
            }

            .small-box .icon {
                font-size: 3rem;
                right: 1rem;
            }
        }

        @media (max-width: 480px) {
            .navbar-user {
                gap: 0.5rem;
            }

            .logout-btn {
                width: 40px;
                height: 40px;
                padding: 0;
            }
        }

        /* Smooth Animations */
        @media (prefers-reduced-motion: no-preference) {
            * {
                scroll-behavior: smooth;
            }
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="top-navbar">
        <div class="navbar-container">
            <!-- Brand Logo -->
            <a href="<?php echo e(route('dosen.dashboard')); ?>" class="navbar-brand">
                <div class="brand-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="brand-text">
                    <h1>SI-RAYA</h1>
                    <p>Dosen</p>
                </div>
            </a>

            <!-- Desktop Navigation Menu -->
            <div class="navbar-menu">
                <a href="<?php echo e(route('dosen.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dosen.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span>
                </a>

                <!-- Presensi Dosen Dropdown -->
                <div class="nav-dropdown">
                    <button class="dropdown-toggle" onclick="toggleDropdown(this)">
                        <i class="fas fa-fingerprint"></i>
                        <span>Presensi Saya</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="<?php echo e(route('dosen.presensi.index')); ?>" class="dropdown-item">
                            <i class="fas fa-calendar-check"></i>
                            <span>Presensi Hari Ini</span>
                        </a>
                        <a href="<?php echo e(route('dosen.presensi.riwayat')); ?>" class="dropdown-item">
                            <i class="fas fa-history"></i>
                            <span>Riwayat Kehadiran</span>
                        </a>
                    </div>
                </div>

                <!-- Presensi Mahasiswa Dropdown -->
                <div class="nav-dropdown">
                    <button class="dropdown-toggle" onclick="toggleDropdown(this)">
                        <i class="fas fa-users"></i>
                        <span>Presensi Mahasiswa</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="<?php echo e(route('dosen.presensiMahasiswa.index')); ?>" class="dropdown-item">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Kelola Presensi</span>
                        </a>
                        <a href="<?php echo e(route('dosen.presensiMahasiswa.riwayat')); ?>" class="dropdown-item">
                            <i class="fas fa-clock"></i>
                            <span>Riwayat Mahasiswa</span>
                        </a>
                    </div>
                </div>

                <a href="<?php echo e(route('dosen.inputNilai.index')); ?>" class="nav-link <?php echo e(request()->routeIs('dosen.inputNilai.*') ? 'active' : ''); ?>">
                    <i class="fas fa-award"></i>
                    <span>Input Nilai</span>
                </a>

                <a href="<?php echo e(route('dosen.jadwalMengajar.index')); ?>" class="nav-link <?php echo e(request()->routeIs('dosen.jadwalMengajar.*') ? 'active' : ''); ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Jadwal Mengajar</span>
                </a>

                <a href="<?php echo e(route('dosen.bantuan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('dosen.bantuan.*') ? 'active' : ''); ?>">
                    <i class="fas fa-question-circle"></i>
                    <span>Bantuan</span>
                </a>
            </div>

            <!-- User Section -->
            <div class="navbar-user">
                <a href="<?php echo e(route('logout')); ?>" 
                   class="logout-btn"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-toggle" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-nav-section">
            <div class="mobile-nav-title">Menu Utama</div>
            <a href="<?php echo e(route('dosen.dashboard')); ?>" class="mobile-nav-link <?php echo e(request()->routeIs('dosen.dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>
        </div>

        <div class="mobile-nav-section">
            <div class="mobile-nav-title">Presensi Saya</div>
            <a href="<?php echo e(route('dosen.presensi.index')); ?>" class="mobile-nav-link">
                <i class="fas fa-calendar-check"></i>
                <span>Presensi Hari Ini</span>
            </a>
            <a href="<?php echo e(route('dosen.presensi.riwayat')); ?>" class="mobile-nav-link">
                <i class="fas fa-history"></i>
                <span>Riwayat Kehadiran</span>
            </a>
        </div>

        <div class="mobile-nav-section">
            <div class="mobile-nav-title">Presensi Mahasiswa</div>
            <a href="<?php echo e(route('dosen.presensiMahasiswa.index')); ?>" class="mobile-nav-link">
                <i class="fas fa-clipboard-check"></i>
                <span>Kelola Presensi</span>
            </a>
            <a href="<?php echo e(route('dosen.presensiMahasiswa.riwayat')); ?>" class="mobile-nav-link">
                <i class="fas fa-clock"></i>
                <span>Riwayat Mahasiswa</span>
            </a>
        </div>

        <div class="mobile-nav-section">
            <div class="mobile-nav-title">Akademik</div>
            <a href="<?php echo e(route('dosen.inputNilai.index')); ?>" class="mobile-nav-link <?php echo e(request()->routeIs('dosen.inputNilai.*') ? 'active' : ''); ?>">
                <i class="fas fa-award"></i>
                <span>Input Nilai</span>
            </a>
            <a href="<?php echo e(route('dosen.jadwalMengajar.index')); ?>" class="mobile-nav-link <?php echo e(request()->routeIs('dosen.jadwalMengajar.*') ? 'active' : ''); ?>">
                <i class="fas fa-calendar-alt"></i>
                <span>Jadwal Mengajar</span>
            </a>
        </div>

        <div class="mobile-nav-section">
            <div class="mobile-nav-title">Dukungan</div>
            <a href="<?php echo e(route('dosen.bantuan.index')); ?>" class="mobile-nav-link <?php echo e(request()->routeIs('dosen.bantuan.*') ? 'active' : ''); ?>">
                <i class="fas fa-question-circle"></i>
                <span>Bantuan & FAQ</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Breadcrumb -->
        <div class="breadcrumb-container">
            <div class="breadcrumb">
                <a href="<?php echo e(route('dosen.dashboard')); ?>" class="breadcrumb-item">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right"></i>
                <span class="breadcrumb-item active"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></span>
            </div>
        </div>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-text">
                &copy; <?php echo e(date('Y')); ?> STAI RAYA - Sistem Informasi Akademik
            </div>
            <div class="footer-links">
                <a href="<?php echo e(route('dosen.bantuan.index')); ?>" class="footer-link">Bantuan</a>
                <a href="<?php echo e(route('dosen.bantuan.dokumentasi')); ?>" class="footer-link">Dokumentasi</a>
                <a href="<?php echo e(route('dosen.bantuan.kontak')); ?>" class="footer-link">Kontak</a>
            </div>
        </div>
    </footer>

    <script>
        // Toggle Dropdown Menu
        function toggleDropdown(button) {
            const dropdown = button.parentElement;
            const allDropdowns = document.querySelectorAll('.nav-dropdown');
            
            // Close other dropdowns
            allDropdowns.forEach(item => {
                if (item !== dropdown) {
                    item.classList.remove('active');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.nav-dropdown')) {
                document.querySelectorAll('.nav-dropdown').forEach(item => {
                    item.classList.remove('active');
                });
            }
        });

        // Toggle Mobile Menu
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileToggle = document.querySelector('.mobile-toggle i');
            
            mobileMenu.classList.toggle('active');
            
            // Toggle icon
            if (mobileMenu.classList.contains('active')) {
                mobileToggle.classList.remove('fa-bars');
                mobileToggle.classList.add('fa-times');
            } else {
                mobileToggle.classList.remove('fa-times');
                mobileToggle.classList.add('fa-bars');
            }
        }

        // Close mobile menu when clicking a link
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', () => {
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileToggle = document.querySelector('.mobile-toggle i');
                
                mobileMenu.classList.remove('active');
                mobileToggle.classList.remove('fa-times');
                mobileToggle.classList.add('fa-bars');
            });
        });

        // Close mobile menu on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileToggle = document.querySelector('.mobile-toggle i');
                
                if (mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    mobileToggle.classList.remove('fa-times');
                    mobileToggle.classList.add('fa-bars');
                }
                
                // Close all dropdowns
                document.querySelectorAll('.nav-dropdown').forEach(item => {
                    item.classList.remove('active');
                });
            }
        });

        // Prevent body scroll when mobile menu is open
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.target.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        });

        const mobileMenuElement = document.getElementById('mobileMenu');
        if (mobileMenuElement) {
            observer.observe(mobileMenuElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\si-raya\resources\views/layouts/dosen.blade.php ENDPATH**/ ?>