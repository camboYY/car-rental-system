<script setup lang="ts">
import * as cars from '@/routes/cars';
import { Link } from '@inertiajs/vue3';

import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import type { BreadcrumbItem, Car } from '@/types';

const { car } = defineProps<{
    car: Car;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cars',
        href: cars.index().url,
    },
];
const altText = `${car.brand} ${car.model}`;
</script>

<template>
    <CustomerLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto max-w-6xl px-4 py-8">
            <!-- Back link -->
            <Link
                :href="cars.index().url"
                class="mb-6 inline-flex items-center text-sm text-blue-600 hover:underline"
            >
                ← Back to cars
            </Link>

            <div class="grid gap-10 lg:grid-cols-2">
                <!-- Image Card -->
                <div
                    class="relative overflow-hidden rounded-2xl bg-gray-100 shadow"
                >
                    <img
                        v-if="car.image_url"
                        :src="`/storage/${car.image_url}`"
                        :alt="altText"
                        class="h-[420px] w-full object-cover"
                    />
                    <div
                        v-else
                        class="flex h-[420px] items-center justify-center text-gray-400"
                    >
                        No image available
                    </div>

                    <!-- Status badge -->
                    <span
                        class="absolute top-4 right-4 rounded-full px-4 py-1 text-sm font-semibold shadow"
                        :class="
                            car.status === 'available'
                                ? 'bg-green-600 text-white'
                                : 'bg-red-600 text-white'
                        "
                    >
                        {{
                            car.status === 'available'
                                ? 'Available'
                                : 'Unavailable'
                        }}
                    </span>
                </div>

                <!-- Info -->
                <div class="flex flex-col justify-between space-y-6">
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight">
                            {{ car.brand }} {{ car.model }}
                        </h1>

                        <p class="mt-2 text-gray-500">
                            Plate number:
                            <span class="font-medium text-gray-800">
                                {{ car.plate_number }}
                            </span>
                        </p>

                        <p class="mt-1 text-gray-500">
                            Category:
                            <span class="font-medium text-gray-800">
                                {{ car.category?.name ?? '—' }}
                            </span>
                        </p>
                    </div>

                    <!-- Pricing -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="rounded-xl border p-4 text-center">
                            <p class="text-sm text-gray-500">Daily</p>
                            <p class="text-2xl font-semibold">
                                ${{ car.price_daily }}
                            </p>
                        </div>

                        <div class="rounded-xl border p-4 text-center">
                            <p class="text-sm text-gray-500">Weekly</p>
                            <p class="text-2xl font-semibold">
                                ${{ car.price_weekly }}
                            </p>
                        </div>

                        <div class="rounded-xl border p-4 text-center">
                            <p class="text-sm text-gray-500">Monthly</p>
                            <p class="text-2xl font-semibold">
                                ${{ car.price_monthly }}
                            </p>
                        </div>
                    </div>

                    <!-- Description -->
                    <p
                        v-if="car.description"
                        class="leading-relaxed text-gray-700"
                    >
                        {{ car.description }}
                    </p>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-4 pt-4">
                        <Link
                            v-if="car.status === 'available'"
                            :href="cars.booking(car.id).url"
                            class="rounded-xl bg-blue-600 px-8 py-3 text-white transition hover:bg-blue-700"
                        >
                            Book Now
                        </Link>

                        <Link
                            :href="cars.index().url"
                            class="rounded-xl border px-8 py-3 text-gray-700 hover:bg-gray-100"
                        >
                            Back
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>
