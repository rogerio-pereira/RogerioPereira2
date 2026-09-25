<script setup lang="ts">
import { onMounted, onUnmounted } from 'vue';
import { updateTheme } from '@/composables/useAppearance';
import CoreSidebarLayout from '@/layouts/core/CoreSidebarLayout.vue';
import type { Appearance, BreadcrumbItem } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);

onMounted(() => {
    document.documentElement.classList.add('dark');
});

onUnmounted(() => {
    const savedAppearance = localStorage.getItem(
        'appearance',
    ) as Appearance | null;

    updateTheme(savedAppearance || 'system');
});
</script>

<template>
    <CoreSidebarLayout :breadcrumbs="breadcrumbs">
        <slot />
    </CoreSidebarLayout>
</template>
