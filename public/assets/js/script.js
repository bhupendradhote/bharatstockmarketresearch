/* ------------------------------------------------------------
   Alpine Intersect Plugin
------------------------------------------------------------ */

console.log('hello');
document.addEventListener('alpine:init', () => {
    Alpine.directive('intersect', (el, { expression, modifiers }, { evaluateLater, cleanup }) => {
        const evaluate = evaluateLater(expression);

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                let isVisible = false;

                if (modifiers.includes('full')) {
                    isVisible = entry.isIntersecting && entry.intersectionRatio >= 0.9;
                } else if (modifiers.includes('half')) {
                    isVisible = entry.isIntersecting && entry.intersectionRatio >= 0.5;
                } else {
                    isVisible = entry.isIntersecting;
                }

                if (isVisible) {
                    evaluate();
                    if (modifiers.includes('once')) observer.disconnect();
                }
            });
        }, {
            threshold: buildThresholds(modifiers)
        });

        observer.observe(el);
        cleanup(() => observer.disconnect());
    });

    function buildThresholds(mod) {
        if (mod.includes("full")) return [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1];
        if (mod.includes("half")) return [0, 0.5, 1];
        return [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1];
    }
});


/* ------------------------------------------------------------
   Vanilla JS Scroll Animation (data-animate)
------------------------------------------------------------ */
function initScrollAnimations() {
    const animated = new Set();

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !animated.has(entry.target)) {
                entry.target.classList.add('animated');
                animated.add(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));

    // Items already visible at load
    document.querySelectorAll('[data-animate]').forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            el.classList.add('animated');
            animated.add(el);
        }
    });
}


/* ------------------------------------------------------------
   FAQ Toggle Script
------------------------------------------------------------ */
function initFAQToggle() {
    document.querySelectorAll('.faq-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            const content = btn.nextElementSibling;
            const arrow = btn.querySelector('.faq-arrow');
            const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

            // Close other FAQs
            document.querySelectorAll('.faq-content').forEach((el) => {
                if (el !== content) {
                    el.style.maxHeight = '0px';
                    el.previousElementSibling.querySelector('.faq-arrow').style.transform = 'rotate(0deg)';
                }
            });

            // Toggle this FAQ
            if (isOpen) {
                content.style.maxHeight = '0px';
                arrow.style.transform = 'rotate(0deg)';
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                arrow.style.transform = 'rotate(180deg)';
            }
        });
    });
}


/* ------------------------------------------------------------
   Auto-Slider for Testimonials
------------------------------------------------------------ */
function initSlider() {
    let interval = setInterval(() => {
        const carousel = document.querySelector('[x-data]');
        if (carousel?.__x) {
            const state = carousel.__x.$data;
            if (state?.next) state.next();
        }
    }, 5000);

    const container = document.querySelector('.relative');
    if (container) {
        container.addEventListener('mouseenter', () => clearInterval(interval));
        container.addEventListener('mouseleave', () => {
            interval = setInterval(() => {
                const carousel = document.querySelector('[x-data]');
                if (carousel?.__x) {
                    const state = carousel.__x.$data;
                    if (state?.next) state.next();
                }
            }, 5000);
        });
    }
}


/* ------------------------------------------------------------
   INIT ALL SCRIPTS (Single DOMContentLoaded)
------------------------------------------------------------ */
document.addEventListener("DOMContentLoaded", () => {
    initScrollAnimations();
    initFAQToggle();
    initSlider();
});
