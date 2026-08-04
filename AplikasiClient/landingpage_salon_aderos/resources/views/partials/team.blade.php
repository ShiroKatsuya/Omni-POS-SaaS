<section id="tim" class="section-padding section-soft">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-kicker">Tim Beautician</span>
            <h2 class="section-title">Ditangani oleh profesional yang teliti dan berpengalaman.</h2>
        </div>
        <div class="row g-4">
            @foreach ($team as $member)
            <div class="col-sm-6 col-lg-3 reveal">
                <article class="team-card h-100">
                    <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}" loading="lazy">
                    <div class="team-body">
                        <h3>{{ $member['name'] }}</h3>
                        <p>{{ $member['role'] }}</p>
                        <span>{{ $member['experience'] }} pengalaman</span>
                        <div class="social-links">
                            <a href="#" aria-label="Instagram {{ $member['name'] }}"><i class="bi bi-instagram"></i></a>
                            <a href="#" aria-label="TikTok {{ $member['name'] }}"><i class="bi bi-tiktok"></i></a>
                            <a href="#" aria-label="LinkedIn {{ $member['name'] }}"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>