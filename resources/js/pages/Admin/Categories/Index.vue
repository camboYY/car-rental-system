<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { Head, router, useForm } from '@inertiajs/vue3';

defineProps<{ categories: any }>();

const form = useForm({ name: '' });

const submit = () => {
    form.post('/admin/categories', {
        onSuccess: () => form.reset(),
    });
};

const toggle = (id: number) => {
    router.patch(`/admin/categories/${id}/toggle`);
};

const destroy = (id: number) => {
    if (confirm('Delete this category?')) {
        router.delete(`/admin/categories/${id}`);
    }
};

const breadcrumbs = [
    {
        title: 'Vehicle Categories',
        href: admin.categories.index().url,
    },
];
</script>

<template>
    <AppLayout title="Vehicle Categories" :breadcrumbs="breadcrumbs">
        <Head title="Vehicle Categories Management" />
        <div class="space-y-6 p-6">
            <h1 class="text-xl font-bold">Vehicle Categories Management</h1>

            <!-- Create -->
            <form @submit.prevent="submit" class="flex gap-3">
                <input
                    v-model="form.name"
                    class="w-1/2 rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Category name"
                />
                <Button class="btn-primary">Add</Button>
            </form>

            <!-- List -->
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="c in categories.data" :key="c.id">
                        <td class="text-center">{{ c.name }}</td>
                        <td class="text-center">
                            <span
                                :class="
                                    c.is_active
                                        ? 'text-green-600'
                                        : 'text-red-600'
                                "
                            >
                                {{ c.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="space-x-2 text-center">
                            <button @click="toggle(c.id)" class="text-blue-600">
                                Toggle
                            </button>
                            <button @click="destroy(c.id)" class="text-red-600">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
