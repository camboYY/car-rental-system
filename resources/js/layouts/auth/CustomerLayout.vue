<script setup lang="ts">
import { customerMenu } from '@/lib/constant';
import { isActive } from '@/lib/utils';
import { Inertia } from '@inertiajs/inertia';
import { Link, usePage } from '@inertiajs/vue3';
import { LogOutIcon } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

const show = ref(true);

const page = usePage();

const flash = computed(() => {
    return page.props.flash as {
        success?: string;
        error?: string;
    };
});

const logout = () => {
    Inertia.post('/logout');
};

watch(
    [flash],
    () => {
        show.value = true;
        setTimeout(() => (show.value = false), 3000);
    },
    { immediate: true },
);
</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow">
            <nav class="space-y-2 px-4 py-6">
                <Link
                    v-for="item in customerMenu"
                    :key="item.title"
                    :href="item.href"
                    class="flex items-center gap-3 rounded px-3 py-2 text-sm transition"
                    :class="{
                        'bg-blue-100 text-blue-700': isActive(
                            item.match,
                            page.url,
                        ),
                        'text-gray-700 hover:bg-gray-100': !isActive(
                            item.match,
                            page.url,
                        ),
                    }"
                >
                    <component :is="item.icon" class="h-4 w-4" />
                    <span>{{ item.title }}</span>
                </Link>
                <!-- Logout button -->
                <button
                    @click="logout"
                    class="flex w-full cursor-pointer items-center gap-3 rounded px-3 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                    <LogOutIcon class="h-4 w-4" />
                    <span>Logout</span>
                </button>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6">
            <!-- Flash messages -->
            <div
                v-if="flash.success && show"
                class="mb-4 rounded bg-green-100 px-4 py-2 text-green-800"
            >
                {{ flash.success }}
            </div>
            <div
                v-if="flash.error && show"
                class="mb-4 rounded bg-red-100 px-4 py-2 text-red-800"
            >
                {{ flash.error }}
            </div>

            <slot />
        </main>
    </div>
</template>

<style scoped>
.nav-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-radius: 6px;
}
</style>
