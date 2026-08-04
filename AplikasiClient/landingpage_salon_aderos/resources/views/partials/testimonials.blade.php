<section id="testimoni" class="section-padding">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-kicker">Testimoni</span>
            <h2 class="section-title">Cerita pelanggan yang kembali karena hasil dan kenyamanan.</h2>
        </div>
        <div id="testimonialSlider" class="carousel slide reveal" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach (array_chunk($testimonials, 3) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach ($chunk as $testimonial)
                        <div class="col-lg-4">
                            <article class="testimonial-card h-100">
                                <img src="{{ $testimonial['photo'] }}" alt="{{ $testimonial['name'] }}" loading="lazy">
                                <div class="stars" aria-label="Rating 5 dari 5">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>"{{ $testimonial['comment'] }}"</p>
                                <h3>{{ $testimonial['name'] }}</h3>
                            </article>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            <div class="carousel-controls">
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialSlider"
                    data-bs-slide="prev" aria-label="Testimoni sebelumnya">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialSlider"
                    data-bs-slide="next" aria-label="Testimoni berikutnya">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>