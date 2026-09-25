<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

defineProps<{
    action: string;
    testId: string;
}>();
</script>

<template>
    <Form
        :action="action"
        method="delete"
        class="inline"
        v-slot="{ processing }"
    >
        <Button
            type="submit"
            variant="ghost"
            size="sm"
            class="text-destructive hover:text-destructive/80"
            :disabled="processing"
            :data-test="testId"
        >
            Delete
        </Button>
    </Form>
</template>
