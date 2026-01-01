<script setup lang="ts">
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import { Invoice } from '@/types';

defineProps<{
    invoices: Invoice[];
}>();
</script>

<template>
    <CustomerLayout>
        <div>
            <h1 class="mb-4 text-2xl font-bold">My Invoices</h1>

            <div class="overflow-hidden rounded bg-white shadow">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Invoice</th>
                            <th class="p-3">Car</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Day(s)</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="inv in invoices"
                            :key="inv.id"
                            class="border-t"
                        >
                            <td class="p-3 text-center">
                                {{ inv.invoice_number }}
                            </td>
                            <td class="p-3 text-center">{{ inv.car }}</td>
                            <td class="p-3 text-center">
                                ${{ inv.total_price }}
                            </td>
                            <td class="p-3 text-center">
                                {{ inv.tatal_days }}
                            </td>
                            <td class="p-3 text-center">
                                <span
                                    class="rounded px-2 py-1 text-xs"
                                    :class="
                                        inv.payment_status === 'paid'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-yellow-100 text-yellow-700'
                                    "
                                >
                                    {{ inv.payment_status }}
                                </span>
                            </td>
                            <td class="p-3 text-center">
                                <a
                                    :href="`/invoices/${inv.id}`"
                                    class="text-blue-600 hover:underline"
                                >
                                    View
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </CustomerLayout>
</template>
