<template>
    <div>
        <h2 class="font-semibold">{{ car.brand }} {{ car.model }}</h2>

        <p>Plate: {{ car.plate_number }}</p>
        <p>Price/day: ${{ car.price_per_day }}</p>
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Pickup Location
            </label>
            <select
                v-model="form.pickup_location"
                class="mt-1 block w-1/2 rounded border px-3 py-2"
            >
                <option value="Phnom Penh Airport">Phnom Penh Airport</option>
                <option value="Siem Reap Airport">Siem Reap Airport</option>
            </select>
        </div>
        <div>
            <label
                class="block text-sm font-medium text-gray-700"
                for="startDate"
                >Start date</label
            >
            <input
                id="startDate"
                type="date"
                required
                v-model="form.start_date"
                class="mt-1 block w-1/2 rounded border px-3 py-2"
            />
            <p v-if="form.errors.start_date" class="text-sm text-red-600">
                {{ form.errors.start_date }}
            </p>
        </div>
        <div>
            <label
                class="block text-sm font-medium text-gray-700"
                for="startDate"
                >Start date</label
            >
            <input
                id="startDate"
                type="date"
                required
                v-model="form.end_date"
                class="mt-1 block w-1/2 rounded border px-3 py-2"
            />
            <p v-if="form.errors.end_date" class="text-sm text-red-600">
                {{ form.errors.end_date }}
            </p>
        </div>
        <div class="mt-2">
            <button
                @click="bookCar(car.id)"
                class="cursor-pointer rounded bg-blue-600 px-4 py-1 text-white hover:bg-transparent hover:text-black hover:outline-1 hover:outline-blue-600"
            >
                Book
            </button>

            <button
                @click="showCar(car.id)"
                class="ml-3 inline-block cursor-pointer rounded bg-transparent px-4 py-1 text-center text-black outline-1 outline-blue-600 hover:bg-blue-600 hover:text-white"
            >
                Show
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Car } from '@/types';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/vue3';

/**
 * Props typing
 */
defineProps<{
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
}>({
    car_id: 0,
    start_date: '',
    end_date: '',
    pickup_location: 'Phnom Penh Airport',
});

/**
 * Book car
 */
const bookCar = (carId: number): void => {
    form.car_id = carId;
    form.post('/bookings');
};

const showCar = (carId: number): void => {
    Inertia.get(`/cars/${carId}`);
};
</script>

<style lang="scss" scoped></style>
