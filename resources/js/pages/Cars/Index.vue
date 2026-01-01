<script setup lang="ts">
import CarItem from '@/components/Car.vue';
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import * as carsRoute from '@/routes/cars';
import { BreadcrumbItem, Car } from '@/types';

/**
 * Props typing
 */
defineProps<{
    cars: Car[];
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

            <CarItem
                v-for="car in cars"
                :key="car.id"
                :car="car"
                class="mb-4 rounded border p-4"
            />
        </div>
    </CustomerLayout>
</template>
