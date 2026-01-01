<template>
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold">Recent Bookings</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="py-2 text-left">ID</th>
                    <th>Car</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="booking in bookings"
                    :key="booking.id"
                    class="border-b"
                >
                    <td>#{{ booking.id }}</td>
                    <td>{{ booking.carName }}</td>
                    <td>
                        <PaymentBadge :status="booking.paymentStatus" />
                    </td>
                    <td>${{ booking.total }}</td>
                    <td>
                        <Button variant="link">
                            <Link :href="`/bookings/${booking.id}`">
                                View
                            </Link>
                        </Button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import type { Booking } from '@/types';
import { Link } from '@inertiajs/vue3';
import PaymentBadge from './PaymentBadge.vue';
import { Button } from './ui/button';

defineProps<{
    bookings: Booking[];
}>();
</script>
