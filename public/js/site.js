document.documentElement.classList.add('js-ready');

const siteHeader = document.querySelector('.site-header');
if (siteHeader) {
    const syncHeaderOffset = () => {
        document.body.style.paddingTop = `${siteHeader.offsetHeight}px`;
    };
    syncHeaderOffset();
    if ('ResizeObserver' in window) new ResizeObserver(syncHeaderOffset).observe(siteHeader);
}

const revealItems = document.querySelectorAll('.public-site .reveal');
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if ('IntersectionObserver' in window && !reduceMotion) {
    const observer = new IntersectionObserver((entries, activeObserver) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                activeObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -24px 0px' });

    revealItems.forEach((item) => observer.observe(item));
} else {
    revealItems.forEach((item) => item.classList.add('is-visible'));
}

document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('[data-carousel-slide]')];
    const dots = [...carousel.querySelectorAll('[data-carousel-to]')];
    const status = carousel.querySelector('[data-carousel-status]');
    const toggle = carousel.querySelector('[data-carousel-toggle]');
    let activeIndex = 0;
    let intervalId;
    let pausedByUser = false;

    if (slides.length < 2) {
        if (toggle) toggle.hidden = true;
        return;
    }

    const showSlide = (index) => {
        activeIndex = (index + slides.length) % slides.length;
        slides.forEach((slide, slideIndex) => {
            const active = slideIndex === activeIndex;
            slide.hidden = !active;
            slide.setAttribute('aria-hidden', String(!active));
            if (dots[slideIndex]) {
                if (active) dots[slideIndex].setAttribute('aria-current', 'true');
                else dots[slideIndex].removeAttribute('aria-current');
            }
        });
        if (status) status.textContent = `${String(activeIndex + 1).padStart(2, '0')} / ${String(slides.length).padStart(2, '0')}`;
    };

    const stopAutoplay = () => window.clearInterval(intervalId);
    const syncAutoplay = () => {
        stopAutoplay();
        if (!pausedByUser && !reduceMotion && carousel.dataset.autoplay === 'true') {
            intervalId = window.setInterval(() => showSlide(activeIndex + 1), 6500);
        }
        if (toggle) {
            const playing = !pausedByUser && !reduceMotion;
            toggle.setAttribute('aria-pressed', String(playing));
            toggle.setAttribute('aria-label', playing ? 'Pause automatic slides' : 'Resume automatic slides');
            toggle.textContent = playing ? 'Pause' : 'Play';
        }
    };

    carousel.querySelector('[data-carousel-prev]')?.addEventListener('click', () => showSlide(activeIndex - 1));
    carousel.querySelector('[data-carousel-next]')?.addEventListener('click', () => showSlide(activeIndex + 1));
    dots.forEach((dot) => dot.addEventListener('click', () => showSlide(Number(dot.dataset.carouselTo))));
    toggle?.addEventListener('click', () => {
        pausedByUser = !pausedByUser;
        syncAutoplay();
    });
    carousel.addEventListener('pointerenter', stopAutoplay);
    carousel.addEventListener('pointerleave', syncAutoplay);
    carousel.addEventListener('focusin', stopAutoplay);
    carousel.addEventListener('focusout', (event) => {
        if (!carousel.contains(event.relatedTarget)) syncAutoplay();
    });
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stopAutoplay();
        else syncAutoplay();
    });

    showSlide(0);
    syncAutoplay();
});