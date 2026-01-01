<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
const page = usePage();
const flash = page.props.flash as { success?: string; error?: string };

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <template>
            <div v-if="flash.success" class="alert alert-success">
                {{ flash.success }}
            </div>
            <div v-if="flash.error" class="alert alert-error">
                {{ flash.error }}
            </div>
        </template>
        <slot />
    </AppLayout>
</template>
