<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi STAI RAYA - Kampus di Naungi Yayasan Pondok Pesantren Mlokorejo, Jember">
    <title>@yield('title', 'SI-RAYA STAI RAYA')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        :root {
            --primary-green: #2C5E1A;
            --secondary-green: #4A7C59;
            --background-light: #F8FAFC;
            --text-dark: #1A202C;
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
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary-green);
            color: white;
            padding: 15px 0;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar-menu {
            display: flex;
            gap: 20px;
        }

        .navbar-menu a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .navbar-menu a:hover {
            color: #D4AF37; /* Warna emas */
        }

        /* Footer */
        .footer {
            background-color: var(--secondary-green);
            color: white;
            text-align: center;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="navbar-brand">SI-Raya STAI RAYA</div>
            <div class="navbar-menu">
                @auth
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer">
        &copy; {{ date('Y') }} STAI RAYA Mlokorejo - Jember
    </footer>

    @stack('scripts')
</body>
</html>
