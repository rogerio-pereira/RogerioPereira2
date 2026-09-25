<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';

defineProps<{
    title: string;
    description: string;
    createHref: string;
    createLabel: string;
    createTestId: string;
}>();
</script>

<template>
    <div class="flex h-full flex-1 flex-col gap-6 p-4">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <Heading :title="title" :description="description" />
            <Button as-child>
                <Link :href="createHref" :data-test="createTestId">
                    {{ createLabel }}
                </Link>
            </Button>
        </div>

        <div class="overflow-x-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            <slot />
        </div>
    </div>
</template>
