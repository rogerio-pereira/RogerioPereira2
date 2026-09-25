<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import CoreFormShell from '@/pages/core/component/CoreFormShell.vue';

defineOptions({
    layout: (props: { user: { id: string } | null }) => ({
        breadcrumbs: [
            {
                title: 'Users',
                href: '/core/users',
            },
            {
                title: props.user === null ? 'New user' : 'Edit user',
            },
        ],
    }),
});

const props = defineProps<{
    user: { id: string; name: string; email: string } | null;
}>();

const isEditing = computed(() => props.user !== null);

const action = computed(() => {
    if (props.user === null) {
        return '/core/users';
    }

    return `/core/users/${props.user.id}`;
});

const method = computed(() => {
    if (props.user === null) {
        return 'post';
    }

    return 'put';
});

const title = computed(() => {
    if (isEditing.value) {
        return 'Edit user';
    }

    return 'New user';
});
</script>

<template>
    <Head :title="title" />

    <CoreFormShell
        :title="title"
        description="Name, email and password for the admin panel"
    >
        <Form
            :action="action"
            :method="method"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    name="name"
                    :default-value="user?.name"
                    required
                    autocomplete="name"
                />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input
                    id="email"
                    name="email"
                    type="email"
                    :default-value="user?.email"
                    required
                    autocomplete="username"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password">Password</Label>
                <Input
                    id="password"
                    name="password"
                    type="password"
                    :required="! isEditing"
                    autocomplete="new-password"
                />
                <p v-if="isEditing" class="text-sm text-muted-foreground">
                    Leave empty to keep the current password.
                </p>
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">Confirm password</Label>
                <Input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    :required="! isEditing"
                    autocomplete="new-password"
                />
            </div>

            <Button
                type="submit"
                :disabled="processing"
                data-test="user-submit"
            >
                Save
            </Button>
        </Form>
    </CoreFormShell>
</template>
