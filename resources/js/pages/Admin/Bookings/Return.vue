<template>
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Car Returns</h1>

            <span class="text-sm text-gray-500">
                {{ bookings.length }} ongoing rental(s)
            </span>
        </div>

        <!-- Empty State -->
        <div
            v-if="bookings.length === 0"
            class="rounded border border-dashed p-8 text-center text-gray-500"
        >
            No cars currently out for rental.
        </div>

        <!-- Returns Table -->
        <div v-else class="overflow-x-auto rounded border">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-sm font-medium text-gray-600"
                        >
                            Customer
                        </th>
                        <th
                            class="px-4 py-3 text-left text-sm font-medium text-gray-600"
                        >
                            Car
                        </th>
                        <th
                            class="px-4 py-3 text-left text-sm font-medium text-gray-600"
                        >
                            Plate
                        </th>
                        <th
                            class="px-4 py-3 text-left text-sm font-medium text-gray-600"
                        >
                            Pickup Location
                        </th>
                        <th
                            class="px-4 py-3 text-left text-sm font-medium text-gray-600"
                        >
                            End Date
                        </th>
                        <th
                            class="px-4 py-3 text-left text-sm font-medium text-gray-600"
                        >
                            Payment
                        </th>
                        <th
                            class="px-4 py-3 text-right text-sm font-medium text-gray-600"
                        >
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="booking in bookings"
                        :key="booking.id"
                        class="border-t hover:bg-gray-50"
                    >
                        <td class="px-4 py-3">
                            <div class="font-medium">
                                {{ booking.customer }}
                            </div>
                        </td>

                        <td class="px-4 py-3">
                            {{ booking.car }}
                        </td>

                        <td class="px-4 py-3">
                            {{ booking.plate }}
                        </td>

                        <td class="px-4 py-3">
                            {{ booking.pickup_location }}
                        </td>

                        <td class="px-4 py-3">
                            {{ booking.end_date }}
                        </td>

                        <td class="px-4 py-3">
                            <span
                                class="inline-block rounded-full px-2 py-0.5 text-xs font-medium"
                                :class="
                                    booking.payment_status === 'PAID'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700'
                                "
                            >
                                {{ booking.payment_status }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-right">
                            <button
                                @click="confirmReturn(booking.id)"
                                class="rounded bg-blue-600 px-4 py-1.5 text-sm text-white hover:bg-blue-700"
                            >
                                Mark Returned
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';

defineProps<{
    bookings: {
        id: number;
        customer: string;
        car: string;
        plate: string;
        pickup_location: string;
        end_date: string;
        payment_status: string;
    }[];
}>();

const confirmReturn = (id: number) => {
    if (!confirm('Confirm car has been returned and inspected?')) return;

    router.post(
        `/admin/bookings/${id}/return`,
        {},
        {
            preserveScroll: true,
        },
    );
};
</script>

<style scoped></style>
