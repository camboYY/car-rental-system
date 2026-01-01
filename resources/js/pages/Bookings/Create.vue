<script setup lang="ts">
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import type { BreadcrumbItem, Car } from '@/types';
import { useForm, usePage } from '@inertiajs/vue3';

const { car } = defineProps<{ car: Car }>();

// Inertia form
const form = useForm({
    car_id: car.id,
    start_date: '',
    end_date: '',
    pickup_location: 'Phnom Penh Airport',
});

// Submit handler
const submitBooking = () => {
    form.post('/bookings', {
        onSuccess: () => {
            form.reset('start_date', 'end_date');
            console.log('Success');
        },
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cars',
        href: '/cars',
    },
    {
        title: car.brand + ' ' + car.model,
        href: '/cars/' + car.id,
    },
    {
        title: 'Book',
        href: '/cars/' + car.id + '/book',
    },
];

const page = usePage();
</script>

<template>
    <CustomerLayout title="Book Car" :breadcrumbs="breadcrumbs">
        <div class="mx-auto max-w-md">
            <h2 class="mb-4 text-xl font-semibold">
                Book: {{ car.brand }} {{ car.model }}
            </h2>

            <img
                v-if="car.image_url"
                :src="`/storage/${car.image_url}`"
                :alt="car.brand + ' ' + car.model"
                class="mb-4 h-64 w-full rounded-lg object-cover"
            />

            <p class="mb-4 text-gray-600">{{ car.description }}</p>

            <form @submit.prevent="submitBooking" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Pickup Location
                    </label>
                    <select
                        v-model="form.pickup_location"
                        class="mt-1 block w-full rounded border px-3 py-2"
                    >
                        <option value="Phnom Penh Airport">
                            Phnom Penh Airport
                        </option>
                        <option value="Siem Reap Airport">
                            Siem Reap Airport
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Start Date
                    </label>
                    <input
                        type="date"
                        v-model="form.start_date"
                        class="mt-1 block w-full rounded border px-3 py-2"
                        required
                    />
                    <p
                        v-if="page.props.errors.start_date"
                        class="text-sm text-red-600"
                    >
                        {{ page.props.errors.start_date }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        End Date
                    </label>
                    <input
                        type="date"
                        v-model="form.end_date"
                        class="mt-1 block w-full rounded border px-3 py-2"
                        required
                    />
                    <p
                        v-if="page.props.errors.end_date"
                        class="text-sm text-red-600"
                    >
                        {{ page.props.errors.end_date }}
                    </p>
                </div>

                <button
                    type="submit"
                    class="w-full rounded bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700"
                    :disabled="form.processing"
                >
                    Book Now
                </button>
            </form>
        </div>
    </CustomerLayout>
</template>
