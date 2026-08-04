<section id="faq" class="section-padding section-soft">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-kicker">FAQ</span>
            <h2 class="section-title">Pertanyaan yang sering ditanyakan.</h2>
        </div>
        <div class="accordion luxury-accordion reveal" id="faqAccordion">
            @foreach ($faqs as $index => $faq)
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="faq{{ $index }}">
                            {{ $faq['q'] }}
                        </button>
                    </h3>
                    <div id="faq{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">{{ $faq['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

