<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <a class="footer-brand" href="#home">
                    <span class="brand-mark">A</span>
                    <span class="brand-text">Aderose Glowing Salon</span>
                </a>
                <p>Salon kecantikan premium untuk wanita modern yang menginginkan perawatan profesional, higienis, dan
                    elegan.</p>
                <div class="social-links">
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h3>Menu Cepat</h3>
                <a href="#tentang">Tentang</a>
                <a href="#layanan">Layanan</a>
                <a href="#galeri">Galeri</a>
                <a href="#harga">Harga</a>
            </div>
            <div class="col-6 col-lg-2">
                <h3>Layanan</h3>
                <a href="#layanan">Hair Spa</a>
                <a href="#layanan">Facial</a>
                <a href="#layanan">Nail Art</a>
                <a href="#layanan">Body Spa</a>
            </div>
            <div class="col-lg-4">
                <h3>Newsletter</h3>
                <p>Dapatkan info promo dan tips kecantikan terbaru.</p>
                <form class="newsletter-form" action="#" method="post">
                    @csrf
                    <input type="email" class="form-control" placeholder="Email Anda" aria-label="Email newsletter"
                        required>
                    <button class="btn btn-luxury" type="submit">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Aderose Glowing Salon. All rights reserved.</span>
            <span>Designed for premium beauty experience.</span>
        </div>
    </div>
</footer>