<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { BreadcrumbItem, Car, Category } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

defineProps<{
    cars: {
        data: Car[];
        current_page: number;
        last_page: number;
        links: any[];
    };
    categories: Category[];
}>();

const status = ref('');

const form = useForm({
    brand: '',
    model: '',
    plate_number: '',
    price_per_day: 0,
    image_url: '',
    description: '',
    category_id: '',
    status: '',
    price_weekly: 0,
    price_monthly: 0,
    price_daily: 0,
});

watch(
    () => form.price_per_day,
    () => {
        form.price_daily = form.price_per_day;
    },
);

const submit = () => {
    form.post('/admin/cars', {
        onSuccess: () => form.reset(),
    });
};

const toggleAvailability = (id: number) => {
    router.patch(`/admin/cars/${id}/toggle`, {
        status: form.status,
        preserveScroll: true,
    });
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

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Car Management',
        href: admin.cars.index().url,
    },
];
</script>

<template>
    <AppLayout title="Cars" :breadcrumbs="breadcrumbs">
        <Head title="Car Management" />
        <div class="p-6">
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
                    />
                    <InputError :message="form.errors.price_per_day" />
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
                <div class="gap-1">
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

                    <InputError :message="form.errors.category_id" />
                </div>
                <div class="gap-1">
                    <select
                        name="status"
                        placeholder="Status"
                        v-model="form.status"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Select Status</option>
                        <option value="available">Available</option>
                        <option value="rented">Rented</option>
                        <option value="mantenance">Mantenance</option>
                    </select>
                    <InputError :message="form.errors.status" />
                </div>
                <div class="col-span-3">
                    <div class="rounded bg-white p-6 shadow">
                        <h2 class="mb-4 text-lg font-semibold">
                            Rental Pricing
                        </h2>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <input
                                    v-model="form.price_daily"
                                    type="number"
                                    disabled
                                    placeholder="Daily Price"
                                    class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                            </div>

                            <div>
                                <input
                                    v-model="form.price_weekly"
                                    type="number"
                                    placeholder="Weekly Price"
                                    class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                            </div>

                            <div>
                                <input
                                    v-model="form.price_monthly"
                                    type="number"
                                    placeholder="Monthly Price"
                                    class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <Button class="w-full">Add Car</Button>
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
                                    car.status === 'available'
                                        ? 'text-green-600'
                                        : 'text-red-600'
                                "
                            >
                                {{
                                    car.status === 'available'
                                        ? 'Available'
                                        : 'Unavailable'
                                }}
                            </span>
                        </td>
                        <td>{{ car?.category?.name }}</td>
                        <td class="space-x-2 text-center">
                            <select
                                v-model="form.status"
                                class="w-1/3 rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                v-on:change="toggleAvailability(car.id)"
                            >
                                <option value="">Select Status</option>
                                <option value="available">Available</option>
                                <option value="rented">Rented</option>
                                <option value="mantenance">Mantenance</option>
                            </select>
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
