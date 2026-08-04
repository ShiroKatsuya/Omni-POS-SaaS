<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="@yield('meta_description', 'Salon kecantikan premium untuk rambut, wajah, kuku, dan body treatment dengan beautician profesional.')">
    <meta name="keywords" content="salon kecantikan, beauty salon, hair spa, facial, nail art, make up, body spa">
    <meta name="author" content="Arya Ghiffari, S.T.">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="@yield('title', 'Aderose Glowing Salon')">
    <meta property="og:description"
        content="Beauty begins with confidence. Reservasi salon premium untuk tampilan terbaik Anda.">
    <meta property="og:type" content="website">
    <meta property="og:image"
        content="https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=1200&q=80">
    <title>@yield('title', 'Aderose Glowing Salon')</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌸</text></svg>">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://images.unsplash.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-bs-spy="scroll" data-bs-target="#mainNavbar" data-bs-offset="90" tabindex="0">
    <div class="page-loader" aria-hidden="true">
        <div class="loader-mark">L</div>
    </div>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <a class="floating-whatsapp"
        href="https://wa.me/6282214045556?text=Halo%2C%20saya%20ingin%20berkonsultasi%20mengenai%20layanan%20di%20Rusdi%20Salon."
        target="_blank" rel="noopener" aria-label="Chat WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <button class="back-to-top" type="button" aria-label="Kembali ke atas">
        <i class="bi bi-arrow-up"></i>
    </button>

    <div class="modal fade" id="galleryLightbox" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">
                <button type="button" class="btn-close btn-close-white ms-auto mb-3" data-bs-dismiss="modal"
                    aria-label="Tutup"></button>
                <img class="img-fluid rounded-4 shadow-lg lightbox-image" src="" alt="Preview galeri salon">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>

</html>