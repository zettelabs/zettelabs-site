// Reveal parts of each section as they scroll in, staggered within the section.
const items = document.querySelectorAll('[data-reveal]');

if (items.length && 'IntersectionObserver' in window && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('section').forEach((section) => {
        section.querySelectorAll('[data-reveal]').forEach((el, i) => {
            el.style.transitionDelay = `${Math.min(i, 6) * 70}ms`;
        });
    });

    const observer = new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-in');
                    observer.unobserve(entry.target);
                }
            }
        },
        { rootMargin: '0px 0px -8% 0px' },
    );

    document.documentElement.classList.add('reveal-on');
    items.forEach((el) => observer.observe(el));
}
