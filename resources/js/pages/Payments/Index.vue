<script setup lang="ts">
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import { Payment } from '@/types';

defineProps<{
    payments: Payment[];
}>();
</script>

<template>
    <CustomerLayout>
        <div class="mx-auto max-w-5xl space-y-6">
            <h1 class="text-2xl font-semibold">My Payments</h1>

            <div class="overflow-x-auto rounded bg-white shadow">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-3">Booking</th>
                            <th>Total</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Paid At</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="p in payments" :key="p.id" class="border-t">
                            <td class="px-4 py-3">
                                {{ p.car }}<br />
                                <span class="text-xs text-gray-500">{{
                                    p.plate
                                }}</span>
                            </td>

                            <td>${{ p.total_price }}</td>

                            <td class="capitalize">{{ p.payment_method }}</td>

                            <td>
                                <span
                                    class="rounded px-2 py-1 text-xs font-medium"
                                    :class="{
                                        'bg-green-100 text-green-700':
                                            p.payment_status === 'PAID',
                                        'bg-yellow-100 text-yellow-700':
                                            p.payment_status === 'PENDING',
                                    }"
                                >
                                    {{ p.payment_status }}
                                </span>
                            </td>

                            <td>{{ p.paid_at ?? '-' }}</td>

                            <td class="px-4 text-right">
                                <a
                                    :href="`/bookings/${p.id}/invoice`"
                                    class="text-blue-600 hover:underline"
                                >
                                    Invoice
                                </a>
                            </td>
                        </tr>

                        <tr v-if="payments.length === 0">
                            <td
                                colspan="6"
                                class="py-6 text-center text-gray-500"
                            >
                                No payments found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </CustomerLayout>
</template>
