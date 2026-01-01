<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps<{
    carId: number;
    images: { id: number; path: string; is_primary: boolean }[];
}>();

const upload = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (!file) return;

    const form = new FormData();
    form.append('image', file);

    router.post(`/admin/cars/${props.carId}/images`, form);
};

const remove = (id: number) => {
    if (confirm('Delete image?')) {
        router.delete(`/admin/cars/images/${id}`);
    }
};
</script>

<template>
    <AppLayout
        title="Images"
        :breadcrumbs="[{ title: 'Cars', href: '/admin/cars' }]"
    >
        <Head title="Images" />

        <div class="align-center justify-center space-y-4 space-x-3 px-2">
            <input
                type="file"
                @change="upload"
                class="cursor-pointer rounded-md bg-blue-600 px-1 py-1 text-white"
            />

            <div class="grid grid-cols-4 gap-4">
                <div v-for="img in images" :key="img.id" class="relative">
                    <img
                        :src="`/storage/${img.path}`"
                        class="h-32 w-full rounded object-cover"
                    />
                    <button
                        @click="remove(img.id)"
                        class="absolute top-1 right-1 rounded bg-red-600 px-2 py-1 text-xs text-white"
                    >
                        ✕
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
