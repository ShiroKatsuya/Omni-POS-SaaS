document.addEventListener('DOMContentLoaded', () => {
    const loader = document.querySelector('.page-loader');
    const navbar = document.querySelector('#mainNavbar');
    const backToTop = document.querySelector('.back-to-top');
    const counters = document.querySelectorAll('.counter');
    const reveals = document.querySelectorAll('.reveal');
    const galleryButtons = document.querySelectorAll('[data-gallery-src]');
    const lightboxImage = document.querySelector('.lightbox-image');
    const bookingForm = document.querySelector('.booking-form');

    window.addEventListener('load', () => {
        loader?.classList.add('is-hidden');
    });

    const updateChrome = () => {
        const isScrolled = window.scrollY > 40;
        navbar?.classList.toggle('scrolled', isScrolled);
        backToTop?.classList.toggle('is-visible', window.scrollY > 500);
    };

    updateChrome();
    window.addEventListener('scroll', updateChrome, { passive: true });

    document.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const target = document.querySelector(link.getAttribute('href'));
            if (!target) return;

            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });

            const navCollapse = document.querySelector('.navbar-collapse.show');
            if (navCollapse && window.bootstrap) {
                window.bootstrap.Collapse.getOrCreateInstance(navCollapse).hide();
            }
        });
    });

    backToTop?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.14 });

    reveals.forEach((item) => revealObserver.observe(item));

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;

            const counter = entry.target;
            const target = Number(counter.dataset.target || 0);
            const duration = 1300;
            const start = performance.now();

            const tick = (time) => {
                const progress = Math.min((time - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                counter.textContent = Math.floor(target * eased).toLocaleString('id-ID');

                if (progress < 1) {
                    requestAnimationFrame(tick);
                }
            };

            requestAnimationFrame(tick);
            counterObserver.unobserve(counter);
        });
    }, { threshold: 0.7 });

    counters.forEach((counter) => counterObserver.observe(counter));

    galleryButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const imageUrl = button.dataset.gallerySrc;
            if (!imageUrl || !lightboxImage || !window.bootstrap) return;

            lightboxImage.src = imageUrl;
            window.bootstrap.Modal.getOrCreateInstance(document.querySelector('#galleryLightbox')).show();
        });
    });

    bookingForm?.addEventListener('submit', (event) => {
        event.preventDefault();

        const submitButton = bookingForm.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Mengirim...';

        setTimeout(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'Booking Terkirim';
            bookingForm.reset();

            setTimeout(() => {
                submitButton.textContent = originalText;
            }, 1800);
        }, 850);
    });
});

