<template>
    <div class="mb-6 rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold">Current Rental</h2>

        <div class="flex justify-between">
            <div>
                <p><b>Car:</b> {{ booking.carName }}</p>
                <p><b>Plate:</b> {{ booking.plate }}</p>
                <p>
                    <b>Duration:</b>
                    {{ booking.startDate }} → {{ booking.endDate }}
                </p>
            </div>

            <span :class="statusClass(booking.status)">
                {{ booking.status }}
            </span>
        </div>

        <RouterLink
            :to="`/bookings/${booking.id}`"
            class="mt-4 inline-block text-blue-600 hover:underline"
        >
            View Booking →
        </RouterLink>
    </div>
</template>

<script setup lang="ts">
import { statusClass } from '@/lib/utils';
import type { Booking } from '@/types';
defineProps<{
    booking: Booking;
}>();
</script>
