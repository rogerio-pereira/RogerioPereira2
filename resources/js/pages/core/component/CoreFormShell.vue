<script setup lang="ts">
import Heading from '@/components/Heading.vue';

defineProps<{
    title: string;
    description: string;
}>();
</script>

<template>
    <div class="flex h-full flex-1 flex-col gap-6 p-4">
        <Heading :title="title" :description="description" />

        <div class="w-full rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border">
            <slot />
        </div>
    </div>
</template>
