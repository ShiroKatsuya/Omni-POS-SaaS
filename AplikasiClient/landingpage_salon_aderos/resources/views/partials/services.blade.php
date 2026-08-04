<section id="layanan" class="section-padding section-soft">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-kicker">Layanan</span>
            <h2 class="section-title">Perawatan premium dari ujung rambut hingga kaki.</h2>
        </div>
        <div class="row g-4">
            @foreach ($services as $service)
            <div class="col-sm-6 col-lg-4 col-xxl-3 reveal">
                <article class="service-card h-100">
                    <div class="service-image">
                        <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" loading="lazy">
                        <span><i class="bi {{ $service['icon'] }}"></i></span>
                    </div>
                    <div class="service-body">
                        <h3>{{ $service['title'] }}</h3>
                        <p>{{ $service['description'] }}</p>
                        @if (!empty($service['price']))
                        <div class="mb-2 fw-bold" style="color: #b8860b;">
                            Rp{{ number_format($service['price'], 0, ',', '.') }}
                        </div>
                        @endif
                        <div class="d-flex gap-2 align-items-center">
                            @if (!empty($service['id']))
                            <button type="button" class="btn btn-luxury btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#checkoutModal"
                                    data-product-id="{{ $service['id'] }}"
                                    data-product-name="{{ $service['title'] }}"
                                    data-product-price="{{ $service['price'] ?? 0 }}"
                                    data-product-icon="{{ $service['icon'] }}">
                                <i class="bi bi-bag-plus me-1"></i>Pesan
                            </button>
                            @endif
                            <a href="#booking" class="card-link">Detail <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>