<template>
    <span class="rounded px-2 py-1 text-xs" :class="badgeClass">
        {{ status }}
    </span>
</template>

<script setup lang="ts">
import type { PaymentStatus } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
    status: PaymentStatus;
}>();

const badgeClass = computed(() => {
    if (props.status === 'PAID') return 'bg-green-100 text-green-700';
    if (props.status === 'PENDING') return 'bg-yellow-100 text-yellow-700';
    return 'bg-red-100 text-red-700';
});
</script>
