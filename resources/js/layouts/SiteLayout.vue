<script setup lang="ts">
import MobileCta from '@/components/site/MobileCta.vue';
import SiteFooter from '@/components/site/SiteFooter.vue';
import SiteHeader from '@/components/site/SiteHeader.vue';
</script>

<template>
    <div class="site flex min-h-screen flex-col">
        <a class="sr-only" href="#main">Skip to content</a>
        <SiteHeader />
        <main id="main" class="flex-1">
            <slot />
        </main>
        <SiteFooter />
        <MobileCta />
    </div>
</template>
