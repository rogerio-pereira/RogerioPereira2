<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';

const page = usePage();
const visible = ref(false);

let stopWatching: () => void = () => {};

function watchHomeSections(hero: HTMLElement, start: HTMLElement) {
    let heroVisible = true;
    let startVisible = false;

    const update = () => {
        visible.value = !heroVisible && !startVisible;
    };

    const heroObserver = new IntersectionObserver((entries) => {
        heroVisible = entries[0].isIntersecting;
        update();
    });
    const startObserver = new IntersectionObserver(
        (entries) => {
            startVisible = entries[0].isIntersecting;
            update();
        },
        { threshold: 0.05 },
    );

    heroObserver.observe(hero);
    startObserver.observe(start);

    return () => {
        heroObserver.disconnect();
        startObserver.disconnect();
    };
}

function watchScroll() {
    const update = () => {
        visible.value = window.scrollY > 480;
    };

    window.addEventListener('scroll', update, { passive: true });
    update();

    return () => window.removeEventListener('scroll', update);
}

// Home page: show after the hero, hide over the form. Other pages: show after the first screen.
function setup() {
    stopWatching();

    const hero = document.getElementById('top');
    const start = document.getElementById('start');

    if (hero && start && 'IntersectionObserver' in window) {
        stopWatching = watchHomeSections(hero, start);

        return;
    }

    stopWatching = watchScroll();
}

onMounted(setup);
watch(
    () => page.url,
    () => nextTick(setup),
);
onBeforeUnmount(() => stopWatching());
</script>

<template>
    <div
        id="mcta"
        class="mcta hidden max-[760px]:block"
        :class="{ show: visible }"
        data-test="mobile-cta"
    >
        <a class="btn btn-primary" href="/#start">
            Start a project <span class="arrow">→</span>
        </a>
    </div>
</template>
