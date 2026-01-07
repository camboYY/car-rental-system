<script setup lang="ts">
import CarItem from '@/components/Car.vue';
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import type { Car } from '@/types';

const { car } = defineProps<{ car: Car }>();
</script>

<template>
    <CustomerLayout title="Book Car">
        <div class="p-6">
            <h1 class="mb-4 text-2xl font-bold">
                You are about to book this car
            </h1>
            <CarItem :car="car" />
        </div>
    </CustomerLayout>
</template>
