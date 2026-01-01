<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import * as bookingRoute from '@/routes/bookings';
import { MyBooking } from '@/types';
import { Link } from '@inertiajs/vue3';

defineProps<{
    bookings: MyBooking[];
}>();

const statusStyle = (status: string) =>
    ({
        BOOKED: 'bg-blue-100 text-blue-700',
        ONGOING: 'bg-yellow-100 text-yellow-700',
        RETURNED: 'bg-green-100 text-green-700',
        CANCELLED: 'bg-red-100 text-red-700',
    })[status];

const breadcrumbs = [
    {
        title: 'Bookings',
        href: '/bookings',
    },
];

const imageUrl =
    'https://stimg.cardekho.com/images/carexteriorimages/630x420/Jaguar/F-Pace/10644/1755774688332/front-left-side-47.jpg?tr=w-664';
</script>

<template>
    <CustomerLayout title="Book Car" :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <div class="ml-0.5">
                <Heading title="My own bookings" />
            </div>
            <template v-if="bookings.length > 0">
                <div class="flex flex-wrap">
                    <div
                        v-for="booking in bookings"
                        :key="booking.id"
                        class="mx-0.5 flex w-full overflow-hidden rounded-2xl border bg-white shadow-sm transition hover:shadow-md"
                    >
                        <!-- Car Image -->
                        <img :src="imageUrl" class="h-50 w-80 object-cover" />

                        <div class="justify-between p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold">
                                        {{ booking.carName }}
                                    </h3>
                                    <p class="text-sm text-muted-foreground">
                                        📍 {{ booking.pickupLocation }}
                                    </p>
                                    <p class="text-sm text-muted-foreground">
                                        📌 Plate Number: {{ booking.plate }}
                                    </p>
                                    <p class="text-sm text-muted-foreground">
                                        💵 Payment Status:
                                        {{ booking.paymentStatus }}
                                    </p>
                                </div>
                                <div>
                                    <span
                                        class="ml-11 rounded-full px-3 py-1 text-xs font-medium"
                                        :class="statusStyle(booking.status)"
                                    >
                                        {{ booking.status }}
                                    </span>
                                    <Button variant="outline" class="ml-4">
                                        <a
                                            :href="booking.invoice_url"
                                            target="_blank"
                                        >
                                            Download Invoice
                                        </a>
                                    </Button>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1 text-sm">
                                <p>
                                    📅 {{ booking.startDate }} →
                                    {{ booking.endDate }}
                                </p>
                                <p class="font-semibold">
                                    💵 Total: ${{ booking.total }}
                                </p>
                            </div>

                            <div class="mt-10">
                                <Button variant="link" size="sm">
                                    <Link
                                        :href="
                                            bookingRoute.show(booking.id).url
                                        "
                                    >
                                        View Details
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="py-16 text-center">
                    <p class="text-lg font-semibold">You have no booked cars</p>
                    <p class="text-muted-foreground">
                        Start renting your first car today 🚗
                    </p>

                    <Link href="/cars" class="btn btn-primary mt-4">
                        Browse Cars
                    </Link>
                </div>
            </template>
        </div>
    </CustomerLayout>
</template>
