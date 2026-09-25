<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { vReveal } from '@/directives/reveal';

export type PaginatorLink = {
    url: string | null;
    label: string;
    active: boolean;
};

export type LaravelPaginator<T> = {
    data: T[];
    current_page: number;
    last_page: number;
    prev_page_url: string | null;
    next_page_url: string | null;
    links: PaginatorLink[];
};

const props = defineProps<{
    paginator: LaravelPaginator<unknown>;
    testId: string;
}>();

// Laravel's first and last links are "Previous" and "Next"; the ones in between are the page numbers and the "..." gaps.
const pages = computed(() => props.paginator.links.slice(1, -1));
</script>

<template>
    <nav
        v-if="paginator.last_page > 1"
        v-reveal
        class="pager flex flex-wrap items-center justify-between gap-4 max-[560px]:justify-center"
        aria-label="Pagination"
        :data-test="testId"
    >
        <Link
            v-if="paginator.prev_page_url"
            class="prev max-[560px]:flex-1"
            :href="paginator.prev_page_url"
            :data-test="`${testId}-previous`"
        >
            ← Previous
        </Link>
        <a v-else class="prev max-[560px]:flex-1" aria-disabled="true">← Previous</a>
        <ol class="flex gap-1.5">
            <li v-for="(page, index) in pages" :key="index" class="flex">
                <span v-if="!page.url" class="gap">…</span>
                <Link
                    v-else
                    :href="page.url"
                    :aria-current="page.active ? 'page' : undefined"
                >
                    {{ page.label }}
                </Link>
            </li>
        </ol>
        <Link
            v-if="paginator.next_page_url"
            class="next mt-0 max-[560px]:flex-1"
            :href="paginator.next_page_url"
            :data-test="`${testId}-next`"
        >
            Next →
        </Link>
        <a v-else class="next mt-0 max-[560px]:flex-1" aria-disabled="true">Next →</a>
    </nav>
</template>
