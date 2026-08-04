<section id="harga" class="section-padding section-soft">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-kicker">Paket Harga</span>
            <h2 class="section-title">Pilih paket kecantikan yang sesuai dengan momen Anda.</h2>
        </div>
        <div class="row g-4">
            @foreach ($prices as $price)
            <div class="col-md-6 col-xl-3 reveal">
                <article class="pricing-card h-100 {{ $price['popular'] ? 'is-popular' : '' }}">
                    @if ($price['popular'])
                    <span class="popular-badge">Most Popular</span>
                    @endif
                    <h3>{{ $price['name'] }}</h3>
                    <div class="price">{{ $price['price'] }}</div>
                    <ul>
                        @foreach ($price['features'] as $feature)
                        <li><i class="bi bi-check2"></i>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    <a href="#booking" class="btn btn-luxury w-100">Pilih Paket</a>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>