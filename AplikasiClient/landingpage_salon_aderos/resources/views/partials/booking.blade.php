<section class="promo-section reveal">
    <div class="container">
        <div class="promo-banner">
            <div>
                <span class="section-kicker text-white">Promo Member Baru</span>
                <h2>Diskon 30% Untuk Member Baru</h2>
                <p>Nikmati treatment pertama dengan harga spesial dan konsultasi kecantikan gratis.</p>
            </div>
            <a class="btn btn-light btn-lg" href="#booking">Hubungi Kami Sekarang</a>
        </div>
    </div>
</section>

<section id="booking" class="section-padding">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 reveal">
                <span class="section-kicker">Booking</span>
                <h2 class="section-title">Atur jadwal perawatan Anda hari ini.</h2>
                <p class="section-text">Isi form singkat ini dan tim kami akan mengonfirmasi jadwal melalui WhatsApp
                    atau email.</p>
                <div class="booking-note">
                    <i class="bi bi-shield-check"></i>
                    <span>Data Anda aman dan hanya digunakan untuk konfirmasi reservasi.</span>
                </div>
            </div>
            <div class="col-lg-7 reveal">
                <form id="bookingForm" class="booking-form" action="#" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama</label>
                            <input id="name" name="name" type="text" class="form-control" placeholder="Nama lengkap"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Nomor HP</label>
                            <input id="phone" name="phone" type="tel" class="form-control" placeholder="08xxxxxxxxxx"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control"
                                placeholder="nama@email.com" required>
                        </div>
                        <div class="col-md-6">
                            <label for="service" class="form-label">Jenis Layanan</label>
                            <select id="service" name="service" class="form-select" required>
                                <option value="">Pilih layanan</option>
                                @foreach ($services as $service)
                                <option value="{{ $service['title'] }}">{{ $service['title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input id="date" name="date" type="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label">Jam</label>
                            <input id="time" name="time" type="time" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea id="notes" name="notes" class="form-control" rows="4"
                                placeholder="Ceritakan kebutuhan Anda"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-luxury btn-lg w-100">Hubungi Kami Sekarang</button>
                        </div>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const form = document.getElementById('bookingForm');
                        const phoneNumber = '6282214045556';

                        if (!form) return;

                        form.addEventListener('submit', function (event) {
                            event.preventDefault();

                            const formData = new FormData(form);
                            const name = formData.get('name')?.toString().trim() || 'Tidak ada nama';
                            const phone = formData.get('phone')?.toString().trim() || 'Tidak ada nomor';
                            const email = formData.get('email')?.toString().trim() || 'Tidak ada email';
                            const service = formData.get('service')?.toString().trim() || 'Tidak ada layanan';
                            const date = formData.get('date')?.toString().trim() || 'Tidak ada tanggal';
                            const time = formData.get('time')?.toString().trim() || 'Tidak ada jam';
                            const notes = formData.get('notes')?.toString().trim() || 'Tidak ada catatan';

                            const message = `Halo, saya ingin reservasi di Rusdi Salon.%0A%0A` +
                                `Nama: ${encodeURIComponent(name)}%0A` +
                                `Nomor HP: ${encodeURIComponent(phone)}%0A` +
                                `Email: ${encodeURIComponent(email)}%0A` +
                                `Layanan: ${encodeURIComponent(service)}%0A` +
                                `Tanggal: ${encodeURIComponent(date)}%0A` +
                                `Jam: ${encodeURIComponent(time)}%0A` +
                                `Catatan: ${encodeURIComponent(notes)}`;

                            window.open(`https://wa.me/${phoneNumber}?text=${message}`, '_blank', 'noopener,noreferrer');
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</section>