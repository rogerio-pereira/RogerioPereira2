<script setup lang="ts">
// Test-only page: renders the public layout so the tests can check it. Not linked from anywhere.
import { Head } from '@inertiajs/vue3';
import PageHead from '@/components/site/PageHead.vue';
import SitePagination from '@/components/site/SitePagination.vue';
import { vReveal } from '@/directives/reveal';

defineProps<{
    title: string;
}>();

const paginator = {
    data: [],
    current_page: 2,
    last_page: 3,
    prev_page_url: '/__test/layout?page=1',
    next_page_url: '/__test/layout?page=3',
    links: [
        { url: '/__test/layout?page=1', label: '&laquo; Previous', active: false },
        { url: '/__test/layout?page=1', label: '1', active: false },
        { url: '/__test/layout?page=2', label: '2', active: true },
        { url: '/__test/layout?page=3', label: '3', active: false },
        { url: '/__test/layout?page=3', label: 'Next &raquo;', active: false },
    ],
};
</script>

<template>
    <Head :title="title" />
    <PageHead
        :crumbs="[{ label: 'Layout test' }]"
        label="LAYOUT TEST"
        :title="title"
        lead="A page used only by the tests."
    />
    <section>
        <div class="wrap">
            <p v-reveal data-test="reveal-target">Content that fades up.</p>
            <SitePagination :paginator="paginator" test-id="pagination" />
        </div>
    </section>
</template>
