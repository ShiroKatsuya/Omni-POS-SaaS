<nav id="mainNavbar" class="navbar navbar-expand-xl navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#home" aria-label="Aderose Glowing Salon">
            <span class="brand-mark">R</span>
            <span class="brand-text">Aderose Glowing Salon</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mx-auto mb-2 mb-xl-0">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="#harga">Harga</a></li>
                <li class="nav-item"><a class="nav-link" href="#tim">Tim</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimoni">Testimoni</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
            </ul>
            <a class="btn btn-luxury btn-sm-lg" href="#booking">Booking Sekarang</a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('#mainNavbar .nav-link');

    function setActiveLink(hash) {
        const target = (hash || '#home').replace('#', '') || 'home';

        navLinks.forEach((link) => {
            const linkTarget = (link.getAttribute('href') || '').replace('#', '');
            const isActive = linkTarget === target;

            link.classList.toggle('active', isActive);
            link.setAttribute('aria-current', isActive ? 'page' : 'false');
        });
    }

    navLinks.forEach((link) => {
        link.addEventListener('click', function () {
            setActiveLink(this.getAttribute('href'));
        });
    });

    setActiveLink(window.location.hash);
    window.addEventListener('hashchange', function () {
        setActiveLink(window.location.hash);
    });
});
</script>