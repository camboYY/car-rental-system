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
const carImage = `https://stimg.cardekho.com/images/carexteriorimages/630x420/Jaguar/F-Pace/10644/1755774688332/front-left-side-47.jpg?tr=w-664`;
</script>

<template>
    <CustomerLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto max-w-5xl p-6">
            <!-- Back -->
            <Link
                :href="cars.index().url"
                class="mb-6 inline-block text-sm text-blue-600 hover:underline"
            >
                ← Back to cars
            </Link>

            <div class="grid gap-8 md:grid-cols-2">
                <!-- Car Image -->
                <div
                    class="flex h-80 items-center justify-center rounded-lg bg-gray-100"
                >
                    <img
                        v-if="car.image_url"
                        :src="carImage"
                        :alt="altText"
                        class="h-full w-full rounded-lg object-cover"
                    />
                    <span v-else class="text-gray-400">No image</span>
                </div>

                <!-- Car Info -->
                <div class="space-y-4">
                    <h1 class="text-3xl font-bold">
                        {{ car.brand }} {{ car.model }}
                    </h1>

                    <p class="text-gray-600">
                        Plate number:
                        <span class="font-medium">{{ car.plate_number }}</span>
                    </p>

                    <p class="text-xl font-semibold">
                        ${{ car.price_per_day }}
                        <span class="text-sm font-normal text-gray-500">
                            / day
                        </span>
                    </p>

                    <p
                        v-if="car.description"
                        class="leading-relaxed text-gray-700"
                    >
                        {{ car.description }}
                    </p>

                    <!-- Status -->
                    <div>
                        <span
                            class="inline-flex rounded-full px-3 py-1 text-sm font-medium"
                            :class="
                                car.is_available
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700'
                            "
                        >
                            {{
                                car.is_available ? 'Available' : 'Not Available'
                            }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4 pt-4">
                        <Link
                            v-if="car.is_available"
                            :href="`/bookings/create?car=${car.id}`"
                            class="rounded bg-blue-600 px-6 py-2 text-white hover:bg-blue-700"
                        >
                            Book Now
                        </Link>

                        <Link
                            :href="cars.index().url"
                            class="rounded border px-6 py-2 text-gray-700 hover:bg-gray-100"
                        >
                            Back
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>
