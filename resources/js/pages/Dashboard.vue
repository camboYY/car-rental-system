<script setup lang="ts">
import ActiveBookingCard from '@/components/ActiveBookingCard.vue';
import BookingTable from '@/components/BookingTable.vue';
import StatCard from '@/components/StatCard.vue';
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import type { Booking } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps<{
    stats: {
        active: number;
        spent: number;
        pending: number;
    };
    activeBooking: Booking | null;
    recentBookings: Booking[];
}>();
</script>

<template>
    <Head title="Dashboard" />
    <CustomerLayout>
        <!-- Stats -->
        <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
            <StatCard label="Active Bookings" :value="stats.active" />
            <StatCard label="Total Spent" :value="`$${stats.spent}`" />
            <StatCard label="Pending Payments" :value="stats.pending" />
        </div>

        <ActiveBookingCard v-if="activeBooking" :booking="activeBooking" />

        <BookingTable :bookings="recentBookings" />
    </CustomerLayout>
</template>
