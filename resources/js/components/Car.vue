<template>
    <div
        class="group rounded-2xl border bg-white p-4 shadow-sm transition hover:shadow-lg"
    >
        <!-- Image -->
        <div class="mb-4 overflow-hidden rounded-xl bg-gray-100">
            <img
                v-if="car.image_url"
                :src="`/storage/${car.image_url}`"
                :alt="`${car.brand} ${car.model}`"
                class="h-48 w-full object-cover transition group-hover:scale-105"
            />
            <div
                v-else
                class="flex h-48 items-center justify-center text-gray-400"
            >
                No image
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-lg font-semibold">{{ car.brand }} {{ car.model }}</h2>

        <p class="text-sm text-gray-500">
            Plate: <span class="font-medium">{{ car.plate_number }}</span>
        </p>

        <p class="mt-1 text-sm text-gray-500">
            Type:
            <span class="font-medium">{{ car.category?.name ?? '—' }}</span>
        </p>

        <!-- Booking Form -->
        <div class="mt-4 space-y-3">
            <div>
                <label class="block text-xs font-medium text-gray-600">
                    Pickup Location
                </label>
                <select
                    v-model="form.pickup_location"
                    class="mt-1 block w-full rounded-lg border px-3 py-2 text-sm"
                >
                    <option value="Phnom Penh Airport">
                        Phnom Penh Airport
                    </option>
                    <option value="Siem Reap Airport">Siem Reap Airport</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600">
                    Start date
                </label>
                <input
                    type="date"
                    v-model="form.start_date"
                    class="mt-1 block w-full rounded-lg border px-3 py-2 text-sm"
                />
                <p v-if="form.errors.start_date" class="text-xs text-red-600">
                    {{ form.errors.start_date }}
                </p>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600">
                    End date
                </label>
                <input
                    type="date"
                    v-model="form.end_date"
                    class="mt-1 block w-full rounded-lg border px-3 py-2 text-sm"
                />
                <p v-if="form.errors.end_date" class="text-xs text-red-600">
                    {{ form.errors.end_date }}
                </p>
            </div>

            <!-- Price Type Selection -->
            <div class="mt-4">
                <label class="mb-2 block text-xs font-medium text-gray-600">
                    Rental Type
                </label>

                <div class="grid grid-cols-3 gap-2">
                    <label
                        class="cursor-pointer rounded-lg border p-2 text-center text-sm transition"
                        :class="
                            form.price_type === 'daily'
                                ? 'border-blue-600 bg-blue-50 text-blue-700'
                                : 'hover:bg-gray-100'
                        "
                    >
                        <input
                            type="radio"
                            class="hidden"
                            value="daily"
                            v-model="form.price_type"
                        />
                        <p class="font-medium">Daily</p>
                        <p class="text-xs text-gray-500">
                            ${{ car.price_per_day }}
                        </p>
                    </label>

                    <label
                        class="cursor-pointer rounded-lg border p-2 text-center text-sm transition"
                        :class="
                            form.price_type === 'weekly'
                                ? 'border-blue-600 bg-blue-50 text-blue-700'
                                : 'hover:bg-gray-100'
                        "
                    >
                        <input
                            type="radio"
                            class="hidden"
                            value="weekly"
                            v-model="form.price_type"
                        />
                        <p class="font-medium">Weekly</p>
                        <p class="text-xs text-gray-500">
                            ${{ car.price_weekly }}
                        </p>
                    </label>

                    <label
                        class="cursor-pointer rounded-lg border p-2 text-center text-sm transition"
                        :class="
                            form.price_type === 'monthly'
                                ? 'border-blue-600 bg-blue-50 text-blue-700'
                                : 'hover:bg-gray-100'
                        "
                    >
                        <input
                            type="radio"
                            class="hidden"
                            value="monthly"
                            v-model="form.price_type"
                        />
                        <p class="font-medium">Monthly</p>
                        <p class="text-xs text-gray-500">
                            ${{ car.price_monthly }}
                        </p>
                    </label>
                </div>
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Weekly pricing is charged per 7 days. Monthly pricing is charged
                per 30 days.
            </p>

            <!-- Live Price Preview -->
            <div
                v-if="pricingSummary"
                class="mt-4 rounded-xl border bg-gray-50 p-4"
            >
                <p class="text-sm text-gray-600">
                    Rental duration:
                    <span class="font-medium">{{ rentalDays }} days</span>
                </p>

                <p class="text-sm text-gray-600">
                    Charged as:
                    <span class="font-medium">
                        {{ pricingSummary.label }}
                    </span>
                </p>

                <p class="mt-2 text-lg font-semibold text-gray-900">
                    Total:
                    <span class="text-blue-600">
                        ${{ pricingSummary.total.toFixed(2) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-5 flex gap-3">
            <button
                @click="bookCar(car.id)"
                class="flex-1 rounded-xl bg-blue-600 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
            >
                Book
            </button>

            <button
                @click="showCar(car.id)"
                class="flex-1 rounded-xl border py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
            >
                Details
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import cars from '@/routes/cars';
import { Car } from '@/types';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

/**
 * Props typing
 */
const { car } = defineProps<{
    car: Car;
}>();

/**
 * Booking form typing
 */
const form = useForm<{
    car_id: number;
    start_date: string;
    end_date: string;
    pickup_location: string;
    price_type: 'daily' | 'weekly' | 'monthly';
}>({
    car_id: 0,
    start_date: '',
    end_date: '',
    pickup_location: 'Phnom Penh Airport',
    price_type: 'daily',
});

/**
 * Calculate rental days (inclusive)
 */
const rentalDays = computed(() => {
    if (!form.start_date || !form.end_date) return 0;

    const start = new Date(form.start_date);
    const end = new Date(form.end_date);

    const diff = (end.getTime() - start.getTime()) / (1000 * 60 * 60 * 24);

    return diff >= 0 ? diff + 1 : 0;
});

/**
 * Calculate charge units & total price
 */
const pricingSummary = computed(() => {
    if (rentalDays.value === 0) {
        return null;
    }

    switch (form.price_type) {
        case 'daily':
            return {
                label: `${rentalDays.value} day(s)`,
                total: car.price_per_day * rentalDays.value,
            };

        case 'weekly':
            const weeks = Math.ceil(rentalDays.value / 7);
            return {
                label: `${weeks} week(s)`,
                total: car?.price_weekly * weeks,
            };

        case 'monthly':
            const months = Math.ceil(rentalDays.value / 30);
            return {
                label: `${months} month(s)`,
                total: car?.price_monthly * months,
            };

        default:
            return null;
    }
});

watch(rentalDays, (days) => {
    if (!days) return;

    if (days >= 30) {
        form.price_type = 'monthly';
    } else if (days >= 7) {
        form.price_type = 'weekly';
    } else {
        form.price_type = 'daily';
    }
});
/**
 * Book car
 */
const bookCar = (carId: number): void => {
    form.car_id = carId;
    form.post('/bookings');
};

const showCar = (carId: number): void => {
    Inertia.get(cars.show(carId).url);
};
</script>

<style lang="scss" scoped></style>
