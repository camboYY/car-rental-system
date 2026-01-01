<script setup lang="ts">
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';

defineProps<{ booking: any }>();
</script>

<template>
    <CustomerLayout>
        <div class="mx-auto max-w-3xl rounded bg-white p-6 shadow">
            <h2 class="mb-4 text-xl font-bold">
                Invoice {{ booking.invoice_number }}
            </h2>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><b>Car:</b> {{ booking.car }}</div>
                <div><b>Pickup:</b> {{ booking.pickup_location }}</div>
                <div><b>Start:</b> {{ booking.start_date }}</div>
                <div><b>End:</b> {{ booking.end_date }}</div>
                <div><b>Days:</b> {{ booking.total_days }}</div>
                <div>
                    <b>Payment:</b> {{ booking.payment_method ?? 'Cash' }}
                </div>
                <div><b>Status:</b> {{ booking.payment_status }}</div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div class="text-lg font-semibold">
                    Total: ${{ booking.total_price }}
                </div>

                <a
                    :href="`/bookings/${booking.id}/invoice`"
                    class="rounded bg-blue-600 px-4 py-2 text-white"
                >
                    Download PDF
                </a>
            </div>
        </div>
    </CustomerLayout>
</template>
