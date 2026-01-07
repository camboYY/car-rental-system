<template>
    <AppLayout title="Returns" :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <!-- Page Header -->
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Car Ongoing Rentals</h1>

                <span class="text-sm text-gray-500">
                    {{ bookings.data.length }} ongoing rental(s)
                </span>
            </div>

            <!-- Empty State -->
            <div
                v-if="bookings.data.length === 0"
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
                            v-for="booking in bookings.data"
                            :key="booking.id"
                            class="border-t hover:bg-gray-50"
                        >
                            <td class="px-4 py-3">
                                <div class="font-medium">
                                    {{ booking.user.name }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                {{ booking.car.brand }} {{ booking.car.model }}
                            </td>

                            <td class="px-4 py-3">
                                {{ booking.car.plate_number }}
                            </td>

                            <td class="px-4 py-3">
                                {{ booking.pickup_location }}
                            </td>

                            <td class="px-4 py-3">
                                {{ formatDate(booking.end_date) }}
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
                <!--- Pagination -->
                <div
                    class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
                >
                    <div class="flex flex-1 justify-between sm:hidden">
                        <a
                            href="#"
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Previous
                        </a>
                        <a
                            href="#"
                            class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Next
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { formatDate } from '@/lib/utils';
import admin from '@/routes/admin';
import { Booking, BreadcrumbItem, Paginated } from '@/types';
import { router } from '@inertiajs/vue3';

defineProps<{
    bookings: Paginated<Booking>;
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

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Car Ongoing Rentals',
        href: admin.bookings.ongoing().url,
    },
];
</script>

<style scoped></style>
