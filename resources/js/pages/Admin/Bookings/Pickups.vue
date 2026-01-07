<template>
    <AppLayout title="Pickups" :breadcrumbs="brecrumbs">
        <div class="p-6">
            <!-- Page Header -->
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Today's Pickups</h1>

                <span class="text-sm text-gray-500">
                    {{ bookings.data.length }} booking(s)
                </span>
            </div>

            <!-- Empty State -->
            <div
                v-if="bookings.data.length === 0"
                class="rounded border border-dashed p-8 text-center text-gray-500"
            >
                No pickups scheduled for today.
            </div>

            <!-- Pickups Table -->
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
                                Start Date
                            </th>
                            <th
                                class="px-4 py-3 text-left text-sm font-medium text-gray-600"
                            >
                                Total
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
                                {{ formatDate(booking.start_date) }}
                            </td>

                            <td class="px-4 py-3">
                                ${{ booking.total_price }}
                            </td>

                            <td class="px-4 py-3 text-right">
                                <button
                                    v-if="booking.payment_status === 'PENDING'"
                                    @click="confirmPickup(booking.id)"
                                    class="rounded bg-green-600 px-4 py-1.5 text-sm text-white hover:bg-green-700"
                                >
                                    Confirm Pickup
                                </button>

                                <span
                                    v-else
                                    class="inline-flex items-center font-semibold text-green-700"
                                >
                                    ✔ Paid
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="flex flex-wrap pt-4">
                <Link
                    v-for="link in bookings.links"
                    :key="link.label"
                    :href="link.url || ''"
                    class="rounded border px-3 py-1 text-sm"
                    :class="{
                        'bg-blue-600 text-white': link.active,
                        'pointer-events-none text-gray-400': !link.url,
                    }"
                >
                    <span v-html="link.label" />
                </Link>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { formatDate } from '@/lib/utils';
import admin from '@/routes/admin';
import { BreadcrumbItem, Car, Paginated, User } from '@/types';
import { router } from '@inertiajs/vue3';

const { bookings } = defineProps<{
    bookings: Paginated<{
        id: number;
        user: User;
        car: Car;
        plate: string;
        pickup_location: string;
        start_date: string;
        total_price: number;
        payment_status: string;
    }>;
}>();

console.log(bookings);
const confirmPickup = (id: number) => {
    if (!confirm('Confirm car pickup and cash payment received?')) return;

    router.post(
        `/admin/bookings/${id}/pickup`,
        {},
        {
            preserveScroll: true,
        },
    );
};
const brecrumbs: BreadcrumbItem[] = [
    {
        title: "Today's Pickups",
        href: admin.bookings.pickups().url,
    },
];
</script>

<style scoped></style>
