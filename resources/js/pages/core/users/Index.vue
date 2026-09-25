<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import CoreDeleteButton from '@/pages/core/component/CoreDeleteButton.vue';
import CoreIndexShell from '@/pages/core/component/CoreIndexShell.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Users',
                href: '/core/users',
            },
        ],
    },
});

defineProps<{
    users: Array<{ id: string; name: string; email: string }>;
}>();
</script>

<template>
    <Head title="Users" />

    <CoreIndexShell
        title="Users"
        description="People who can sign in to the admin panel"
        create-href="/core/users/create"
        create-label="New user"
        create-test-id="users-create"
    >
        <table class="w-full text-sm">
            <thead class="bg-muted/50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Email</th>
                    <th class="px-4 py-3" />
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="user in users"
                    :key="user.id"
                    class="border-t border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <td class="px-4 py-3 font-medium">{{ user.name }}</td>
                    <td class="px-4 py-3 text-muted-foreground">{{ user.email }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <Button as-child variant="ghost" size="sm">
                            <Link
                                :href="`/core/users/${user.id}/edit`"
                                :data-test="`user-edit-${user.id}`"
                            >
                                Edit
                            </Link>
                        </Button>
                        <CoreDeleteButton
                            :action="`/core/users/${user.id}`"
                            :test-id="`user-delete-${user.id}`"
                        />
                    </td>
                </tr>
                <tr v-if="users.length === 0">
                    <td
                        class="px-4 py-6 text-center text-muted-foreground"
                        colspan="3"
                        data-test="users-empty"
                    >
                        No users yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </CoreIndexShell>
</template>
