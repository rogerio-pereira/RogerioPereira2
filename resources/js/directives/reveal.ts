import type { Directive } from 'vue';

let observer: IntersectionObserver | null = null;

function shouldAnimate(): boolean {
    if (!('IntersectionObserver' in window)) {
        return false;
    }

    return !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function getObserver(): IntersectionObserver {
    if (observer) {
        return observer;
    }

    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('in');
                observer?.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 },
    );

    return observer;
}

/** Fades the element up when it enters the viewport (`.reveal` in site.css). */
export const vReveal: Directive<HTMLElement> = {
    mounted(el) {
        el.classList.add('reveal');

        if (!shouldAnimate()) {
            el.classList.add('in');

            return;
        }

        getObserver().observe(el);
    },
    unmounted(el) {
        observer?.unobserve(el);
    },
};
