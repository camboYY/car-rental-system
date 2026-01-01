<template>
    <div class="mx-auto max-w-md border p-6 print:border-0">
        <h1 class="mb-4 text-center text-xl font-bold">Cash Receipt</h1>

        <div class="space-y-2 text-sm">
            <p><strong>Receipt #:</strong> {{ booking.id }}</p>
            <p><strong>Customer:</strong> {{ booking.customer }}</p>
            <p><strong>Car:</strong> {{ booking.car }}</p>
            <p><strong>Plate:</strong> {{ booking.plate }}</p>
            <p><strong>Pickup:</strong> {{ booking.pickup_location }}</p>
            <p>
                <strong>Rental:</strong> {{ booking.start_date }} →
                {{ booking.end_date }}
            </p>

            <hr class="my-3" />

            <p class="text-lg font-bold">Total: ${{ booking.total_price }}</p>

            <p class="font-semibold text-green-600">
                Payment: {{ booking.payment_status }}
            </p>
        </div>

        <!-- QR CODE -->
        <div class="mt-6 text-center">
            <div v-html="qr" class="mx-auto w-40"></div>
            <p class="mt-2 text-xs text-gray-500">Scan to verify booking</p>
        </div>

        <button
            class="mt-6 w-full rounded bg-blue-600 px-4 py-2 text-white print:hidden"
            @click="print"
        >
            Print Receipt
        </button>
    </div>
</template>

<script setup lang="ts">
defineProps<{ booking: any; qr: string }>();

const print = () => window.print();
</script>
