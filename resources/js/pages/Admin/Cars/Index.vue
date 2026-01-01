<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Car, Category } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';

defineProps<{
    cars: {
        data: Car[];
        current_page: number;
        last_page: number;
        links: any[];
    };
    categories: Category[];
}>();

const form = useForm({
    brand: '',
    model: '',
    plate_number: '',
    price_per_day: '',
    image_url: '',
    description: '',
    category_id: '',
});

const submit = () => {
    form.post('/admin/cars', {
        onSuccess: () => form.reset(),
    });
};

const toggleAvailability = (id: number) => {
    router.patch(`/admin/cars/${id}/toggle`);
};

const deleteCar = (id: number) => {
    if (confirm('Delete this car?')) {
        router.delete(`/admin/cars/${id}`, {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Car deleted');
            },
            onError: (errors) => {
                alert(errors?.message ?? 'Failed to delete car');
            },
        });
    }
};
const showImage = (id: number) => {
    router.get(`/admin/cars/${id}/images`);
};

const editCar = (id: number) => {
    router.get(`/admin/cars/${id}/edit`);
};
</script>

<template>
    <AppLayout title="Cars">
        <Head title="Car Management" />
        <div class="p-6">
            <h1 class="mb-4 text-xl font-bold">Car Management</h1>

            <!-- Create -->
            <form @submit.prevent="submit" class="mb-6 grid grid-cols-3 gap-3">
                <div class="gap-1">
                    <input
                        v-model="form.brand"
                        placeholder="Brand"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <InputError :message="form.errors.brand" />
                </div>
                <div class="gap-1">
                    <input
                        v-model="form.model"
                        placeholder="Model"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <InputError :message="form.errors.brand" />
                </div>
                <div class="gap-1">
                    <input
                        v-model="form.plate_number"
                        placeholder="Plate Number"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <InputError :message="form.errors.plate_number" />
                </div>
                <div class="gap-1">
                    <input
                        v-model="form.price_per_day"
                        placeholder="Price / Day"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    /><InputError :message="form.errors.price_per_day" />
                </div>
                <div class="gap-1">
                    <input
                        v-model="form.image_url"
                        placeholder="Image URL"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <InputError :message="form.errors.image_url" />
                </div>
                <div class="gap-1">
                    <input
                        v-model="form.description"
                        placeholder="Description"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <InputError :message="form.errors.description" />
                </div>
                <select
                    v-model="form.category_id"
                    class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Select Category</option>
                    <option
                        v-for="cat in categories"
                        :key="cat.id"
                        :value="cat.id"
                    >
                        {{ cat.name }}
                    </option>
                </select>

                <Button class="w-1/3">Add Car</Button>
            </form>

            <!-- Table -->
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Plate</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="car in cars.data" :key="car.id">
                        <td class="text-center">{{ car.brand }}</td>
                        <td class="text-center">{{ car.model }}</td>
                        <td class="text-center">{{ car.plate_number }}</td>
                        <td class="text-center">${{ car.price_per_day }}</td>
                        <td class="text-center">
                            <span
                                :class="
                                    car.is_available
                                        ? 'text-green-600'
                                        : 'text-red-600'
                                "
                            >
                                {{
                                    car.is_available
                                        ? 'Available'
                                        : 'Unavailable'
                                }}
                            </span>
                        </td>
                        <td>{{ car?.category?.name }}</td>
                        <td class="space-x-2 text-center">
                            <button
                                @click="toggleAvailability(car.id)"
                                class="text-blue-600"
                            >
                                Toggle
                            </button>
                            <button
                                @click="deleteCar(car.id)"
                                class="text-red-600"
                            >
                                Delete
                            </button>
                            <button
                                @click="showImage(car.id)"
                                class="text-blue-600"
                            >
                                Edit Image
                            </button>
                            <button
                                @click="editCar(car.id)"
                                class="text-blue-600"
                            >
                                Edit Info
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4 flex gap-2">
                <button
                    v-for="link in cars.links"
                    :key="link.url"
                    :disabled="!link.url"
                    @click="router.visit(link.url)"
                    v-html="link.label"
                    class="rounded border px-3 py-1"
                    :class="{ 'bg-blue-600 text-white': link.active }"
                />
            </div>
        </div>
    </AppLayout>
</template>
