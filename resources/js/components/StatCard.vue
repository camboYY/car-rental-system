<template>
    <div class="rounded-lg bg-white p-5 shadow">
        <p class="text-sm text-gray-500">{{ label }}</p>
        <p class="text-3xl font-bold">{{ value }}</p>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    label: string;
    value: string | number;
}>();
</script>
