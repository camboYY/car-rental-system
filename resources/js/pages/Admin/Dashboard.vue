<template>
    <Head title="Admin Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <div class="flex justify-between">
                <h1 class="mb-6 text-2xl font-bold">Dashboard</h1>
                <span
                    class="h-8 rounded-full px-2 py-1 text-center text-xs font-semibold"
                    :class="{
                        'bg-blue-100 text-blue-700':
                            $page.props.auth.user.role === 'admin',
                        'bg-green-100 text-green-700':
                            $page.props.auth.user.role === 'staff',
                        'bg-gray-100 text-gray-700':
                            $page.props.auth.user.role === 'user',
                    }"
                >
                    {{ $page.props.auth.user.role }}
                </span>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded border bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Today Pickups</p>
                    <p class="mt-2 text-4xl font-bold text-blue-600">
                        {{ todayPickups }}
                    </p>
                </div>

                <div class="rounded border bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Today Returns</p>
                    <p class="mt-2 text-4xl font-bold text-green-600">
                        {{ todayReturns }}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes/admin';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

defineProps<{
    todayPickups: number;
    todayReturns: number;
}>();
</script>
