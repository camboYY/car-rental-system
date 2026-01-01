<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { User } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';

defineProps<{
    users: {
        data: User[];
        current_page: number;
        last_page: number;
        links: any[];
    };
}>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: 'user',
});

const submit = () => {
    form.post('users', {
        onSuccess: () => form.reset(),
    });
};

const toggleStatus = (id: number) => {
    form.patch('users/' + id + '/toggle');
};

// Pagination
const goToPage = (page: number) => {
    router.get('users', { page }, { preserveState: true });
};
</script>

<template>
    <AppLayout title="Users">
        <Head title="User Management" />
        <div class="p-6">
            <h1 class="mb-4 text-xl font-bold">User Management</h1>

            <!-- Create User -->
            <form @submit.prevent="submit" class="mb-6 grid grid-cols-4 gap-3">
                <div class="gap-1">
                    <input
                        v-model="form.name"
                        placeholder="Name"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <InputError :message="form.errors.name" />
                </div>
                <div class="gap-1">
                    <input
                        v-model="form.email"
                        placeholder="Email"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <InputError :message="form.errors.email" />
                </div>
                <div class="gap-1">
                    <input
                        v-model="form.password"
                        type="password"
                        placeholder="Password"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <InputError :message="form.errors.password" />
                </div>
                <div class="gap-1">
                    <select
                        v-model="form.role"
                        class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        <option value="user">Customer</option>
                    </select>
                    <InputError :message="form.errors.role" />
                </div>
                <Button size="sm" class="w-1/3">Create</Button>
            </form>

            <!-- User List -->
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td class="text-center">{{ user.name }}</td>
                        <td class="text-center">{{ user.email }}</td>
                        <td class="text-center">{{ user.role }}</td>
                        <td class="text-center">
                            <span
                                :class="
                                    user.is_active
                                        ? 'text-green-600'
                                        : 'text-red-600'
                                "
                            >
                                {{ user.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button
                                @click="toggleStatus(user.id)"
                                class="text-sm text-blue-600"
                            >
                                {{ user.is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="mt-4 flex justify-center gap-2">
                <button
                    :disabled="users.current_page === 1"
                    @click="goToPage(users.current_page - 1)"
                    class="rounded border px-3 py-1"
                >
                    Prev
                </button>

                <button
                    v-for="page in users.last_page"
                    :key="page"
                    @click="goToPage(page)"
                    :class="{
                        'bg-blue-600 text-white': page === users.current_page,
                        border: page !== users.current_page,
                    }"
                    class="rounded px-3 py-1"
                >
                    {{ page }}
                </button>

                <button
                    :disabled="users.current_page === users.last_page"
                    @click="goToPage(users.current_page + 1)"
                    class="rounded border px-3 py-1"
                >
                    Next
                </button>
            </div>
        </div>
    </AppLayout>
</template>
