// Reveal parts as they scroll in; only items that arrive together are staggered.
const items = document.querySelectorAll('[data-reveal]');

if (items.length && 'IntersectionObserver' in window && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const observer = new IntersectionObserver(
        (entries) => {
            let n = 0;
            for (const entry of entries) {
                if (entry.isIntersecting) {
                    entry.target.style.transitionDelay = `${Math.min(n++, 6) * 50}ms`;
                    entry.target.classList.add('is-in');
                    observer.unobserve(entry.target);
                }
            }
        },
        { rootMargin: '0px 0px -8% 0px' },
    );

    // Anything already on screen (reload mid-page, /#anchor) stays put instead of blinking out.
    items.forEach((el) => el.getBoundingClientRect().top < innerHeight && el.classList.add('is-in'));
    document.documentElement.classList.add('reveal-on');
    items.forEach((el) => el.classList.contains('is-in') || observer.observe(el));
}

// Marquee pause toggle, for touch and keyboard users who have no hover.
document.querySelectorAll('[data-marquee-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const paused = button.getAttribute('aria-pressed') !== 'true';
        button.setAttribute('aria-pressed', paused);
        document.getElementById(button.getAttribute('aria-controls')).classList.toggle('is-paused', paused);
    });
});
