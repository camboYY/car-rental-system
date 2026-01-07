<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { BreadcrumbItem, Car, Category } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = defineProps<{
    car: Car;
    categories: Category[];
}>();

const form = useForm({
    brand: props.car.brand,
    model: props.car.model,
    plate_number: props.car.plate_number,
    price_per_day: props.car.price_per_day,
    category_id: props.car.category?.id,
    description: props.car.description,
    status: props.car.status,
    images: [] as File[],
    price_weekly: props.car.price_weekly,
    price_monthly: props.car.price_monthly,
    price_daily: props.car.price_daily,
});

watch(
    () => form.price_per_day,
    () => {
        form.price_daily = form.price_per_day;
    },
);

const submit = () => {
    form.put(`/admin/cars/${props.car.id}`, {
        forceFormData: true,
        onSuccess: () => {
            console.log('Success');
            form.reset();
        },
        onError: (errors) => {
            console.log({ errors });
        },
    });
};

const deleteImage = (id: number) => {
    if (confirm('Delete this image?')) {
        router.delete(`/admin/cars/images/${id}`);
    }
};

const onFileChange = (event: Event) => {
    const input = event.target as HTMLInputElement;

    if (!input.files) return;

    form.images = Array.from(input.files);
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Vehicle',
        href: admin.cars.index().url,
    },
];
</script>

<template>
    <AppLayout title="Edit Vehicle" :breadcrumbs="breadcrumbs">
        <Head title="Edit Vehicle" />
        <div class="mx-auto max-w-6xl p-6">
            <form @submit.prevent="submit" class="grid grid-cols-2 gap-6">
                <!-- Left -->
                <div class="space-y-4">
                    <input
                        v-model="form.brand"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Brand"
                    />
                    <input
                        v-model="form.model"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Model"
                    />
                    <input
                        v-model="form.plate_number"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Plate Number"
                    />

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
                            {{ cat.name
                            }}{{
                                cat.id === form.category_id ? ' (selected)' : ''
                            }}
                        </option>
                    </select>
                    <input
                        type="number"
                        v-model="form.price_per_day"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Price per day"
                    />

                    <textarea
                        v-model="form.description"
                        class="h-28 w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Description"
                    />

                    <div class="gap-2">
                        <select
                            name="status"
                            placeholder="Status"
                            v-model="form.status"
                            class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="available">Available</option>
                            <option value="rented">Rented</option>
                            <option value="mantenance">Mantenance</option>
                        </select>
                    </div>
                </div>

                <!-- Right -->
                <div>
                    <h2 class="mb-2 font-semibold">Images</h2>

                    <input
                        type="file"
                        multiple
                        @change="onFileChange"
                        accept="image/*"
                        class="mb-4 w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />

                    <div class="grid grid-cols-3 gap-4">
                        <div
                            v-for="img in car.images"
                            :key="img.id"
                            class="group relative"
                        >
                            <img
                                :src="`/storage/${img.path}`"
                                :alt="img.path"
                                class="h-32 w-full rounded object-cover"
                            />

                            <button
                                type="button"
                                @click="deleteImage(img.id)"
                                class="absolute top-1 right-1 rounded bg-red-600 px-2 py-1 text-xs text-white opacity-0 group-hover:opacity-100"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="rounded bg-white p-6 shadow">
                    <h2 class="mb-4 text-lg font-semibold">Rental Pricing</h2>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <input
                                v-model="form.price_daily"
                                type="number"
                                placeholder="Daily Price"
                                disabled
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

                <!-- Actions -->
                <div class="col-span-2 mt-6 flex justify-end gap-3">
                    <button
                        type="button"
                        class="btn cursor-pointer rounded-md bg-blue-100 px-3 py-2 hover:bg-blue-50"
                        @click="$inertia.visit('/admin/cars')"
                    >
                        Cancel
                    </button>

                    <button
                        :disabled="form.processing"
                        class="btn cursor-pointer rounded-md bg-gray-100 px-3 py-2 hover:bg-gray-50"
                    >
                        Update Vehicle
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
