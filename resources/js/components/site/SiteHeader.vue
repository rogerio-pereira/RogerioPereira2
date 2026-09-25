<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const links = [
    { label: 'Services', href: '/#services', isPage: false },
    { label: 'Cases', href: '/cases', isPage: true },
    { label: 'How it works', href: '/#process', isPage: false },
    { label: 'FAQ', href: '/#faq', isPage: false },
    { label: 'Blog', href: '/blog', isPage: true },
];

const linkClass =
    'max-[920px]:block max-[920px]:border-b max-[920px]:border-line-soft max-[920px]:py-3.5 max-[920px]:text-[13px]';

const menuOpen = ref(false);

function toggleMenu() {
    menuOpen.value = !menuOpen.value;
}

function closeMenu() {
    menuOpen.value = false;
}
</script>

<template>
    <header class="nav" data-test="site-header">
        <div class="wrap flex items-center justify-between gap-6 max-[920px]:gap-3">
            <Link
                class="brand flex items-baseline gap-3"
                href="/"
                aria-label="Rogerio Pereira, home"
            >
                <strong class="max-[420px]:text-[17px]">Rogerio Pereira</strong>
                <span class="max-[920px]:hidden">@rogeriopereira.dev</span>
            </Link>
            <nav aria-label="Main" class="max-[920px]:order-3">
                <button
                    class="menu-btn hidden flex-col items-center justify-center gap-1.5 max-[920px]:flex"
                    type="button"
                    :aria-expanded="menuOpen"
                    aria-controls="main-menu"
                    aria-label="Menu"
                    data-test="menu-button"
                    @click="toggleMenu"
                >
                    <span></span>
                    <span></span>
                </button>
                <ul
                    id="main-menu"
                    class="flex gap-7 max-[920px]:absolute max-[920px]:inset-x-0 max-[920px]:top-[68px] max-[920px]:flex-col max-[920px]:gap-0 max-[920px]:border-b max-[920px]:border-line max-[920px]:bg-[#151719] max-[920px]:px-[var(--gutter)] max-[920px]:pt-2 max-[920px]:pb-4 max-[920px]:shadow-[0_24px_40px_-12px_rgba(0,0,0,0.7)]"
                    :class="menuOpen ? 'max-[920px]:flex' : 'max-[920px]:hidden'"
                    data-test="main-menu"
                    @click="closeMenu"
                >
                    <li v-for="link in links" :key="link.href">
                        <component
                            :is="link.isPage ? Link : 'a'"
                            :href="link.href"
                            :class="linkClass"
                        >
                            {{ link.label }}
                        </component>
                    </li>
                </ul>
            </nav>
            <a
                class="btn btn-primary max-[920px]:ml-auto max-[420px]:px-3.5 max-[420px]:text-sm"
                href="/#start"
            >
                Start a project
            </a>
        </div>
    </header>
</template>
