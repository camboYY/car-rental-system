<script setup lang="ts">
import { Button } from '@/components/ui/button';
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import { statusClass } from '@/lib/utils';
import type { Booking, BreadcrumbItem } from '@/types';

const { booking } = defineProps<{ booking: Booking }>();

const imageUrl = `/storage/${booking.image}`;
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bookings',
        href: '/bookings',
    },
];
</script>

<template>
    <CustomerLayout :breadcrumbs="breadcrumbs" title="Booking Details">
        <div class="mx-auto max-w-3xl rounded-lg bg-white p-6 shadow">
            <h1 class="mb-4 text-2xl font-bold">Booking Details</h1>

            <div class="flex flex-col gap-6 md:flex-row">
                <img
                    :src="imageUrl"
                    alt="Car Image"
                    class="h-50 w-full rounded object-cover md:w-1/2"
                />

                <div class="flex-1 space-y-2">
                    <h2 class="text-xl font-semibold">{{ booking.carName }}</h2>
                    <p>Plate Number: {{ booking.plate }}</p>
                    <p>Pickup Location: {{ booking.pickupLocation }}</p>
                    <p>Start Date: {{ booking.startDate }}</p>
                    <p>End Date: {{ booking.endDate }}</p>
                    <p>Total Price: ${{ booking.total }}</p>

                    <span
                        class="inline-block rounded-full px-3 py-1 text-sm font-medium"
                        :class="statusClass(booking.status)"
                    >
                        {{ booking.status }}
                    </span>

                    <p>
                        Payment Status:
                        <span
                            class="inline-block rounded-full px-3 py-1 text-sm font-medium"
                            :class="
                                booking.paymentStatus === 'PAID'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-yellow-100 text-yellow-700'
                            "
                        >
                            {{ booking.paymentStatus }}
                        </span>
                    </p>

                    <p><strong>Payment Method:</strong> Cash on Pickup</p>

                    <p
                        v-if="booking.paymentStatus === 'PENDING'"
                        class="mt-2 text-sm text-gray-600"
                    >
                        Please pay in cash when picking up the car.
                    </p>

                    <Button variant="outline" class="ml-4">
                        <a :href="booking.invoiceUrl" target="_blank">
                            Download Invoice
                        </a>
                    </Button>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>
