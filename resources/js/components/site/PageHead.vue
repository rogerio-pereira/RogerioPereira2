<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

export type Crumb = {
    label: string;
    href?: string;
};

// "Home" is always the first crumb; `crumbs` lists the pages after it. A crumb without `href` is the current page.
defineProps<{
    crumbs: Crumb[];
    label: string;
    title: string;
    lead?: string;
}>();
</script>

<template>
    <section class="page-head blueprint" data-test="page-head">
        <div class="wrap">
            <ol class="crumbs flex flex-wrap gap-2">
                <li>
                    <Link href="/">Home</Link>
                </li>
                <li v-for="crumb in crumbs" :key="crumb.label">
                    <Link v-if="crumb.href" :href="crumb.href">{{ crumb.label }}</Link>
                    <span v-else aria-current="page">{{ crumb.label }}</span>
                </li>
            </ol>
            <span class="log"><b>{{ label }}</b></span>
            <h1>{{ title }}</h1>
            <p v-if="lead" class="lead">{{ lead }}</p>
        </div>
    </section>
</template>
