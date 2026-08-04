<section id="galeri" class="section-padding">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-kicker">Galeri</span>
            <h2 class="section-title">Nuansa salon premium dengan detail yang menenangkan.</h2>
        </div>
        <div class="masonry-gallery">
            @foreach ($gallery as $index => $image)
            <button class="gallery-item reveal" type="button" data-gallery-src="{{ $image }}"
                aria-label="Buka foto galeri {{ $index + 1 }}">
                <img src="{{ $image }}" alt="Galeri Lumiere Beauty Salon {{ $index + 1 }}" loading="lazy">
                <span><i class="bi bi-plus-lg"></i></span>
            </button>
            @endforeach
        </div>
    </div>
</section>