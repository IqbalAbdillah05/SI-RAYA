<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi STAI RAYA - Kampus di Naungi Yayasan Pondok Pesantren Mlokorejo, Jember">
    <title>@yield('title', 'Autentikasi - STAI RAYA Pesantren')</title>
    
    <!-- Fonts: Nunito untuk body, Amiri untuk heading Islami (opsional) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <main class="auth-main">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>