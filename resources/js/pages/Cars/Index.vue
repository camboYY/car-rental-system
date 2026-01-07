<script setup lang="ts">
import CarItem from '@/components/Car.vue';
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import * as carsRoute from '@/routes/cars';
import { BreadcrumbItem, Car, Paginated } from '@/types';
import { Link } from '@inertiajs/vue3';

/**
 * Props typing
 */
defineProps<{
    cars: Paginated<Car>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cars',
        href: carsRoute.index().url,
    },
];
</script>

<template>
    <CustomerLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <h1 class="mb-4 text-2xl font-bold">Available Cars</h1>
            <div class="flex grid-cols-2 flex-wrap">
                <CarItem
                    v-for="car in cars.data"
                    :key="car.id"
                    :car="car"
                    class="mb-4 rounded-md border p-4"
                />
            </div>
            <!-- Pagination -->
            <div class="flex flex-wrap gap-1">
                <Link
                    v-for="link in cars.links"
                    :key="link.label"
                    :href="link.url || ''"
                    class="rounded border px-3 py-1 text-sm"
                    :class="{
                        'bg-blue-600 text-white': link.active,
                        'pointer-events-none text-gray-400': !link.url,
                    }"
                >
                    <span v-html="link.label" />
                </Link>
            </div>
        </div>
    </CustomerLayout>
</template>
