<script setup lang="ts">
import CustomerLayout from '@/layouts/auth/CustomerLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';

interface User {
    id: number;
    name: string;
    email: string;
    role: string;
}

const page = usePage();
const user = page.props.auth.user as User;

const form = useForm({
    name: user.name,
    email: user.email,
    role: user.role,
});

const updatePasswordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});
</script>

<template>
    <CustomerLayout>
        <div class="mx-auto max-w-4xl space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-semibold">Profile</h1>
                <p class="text-sm text-gray-500">
                    Manage your account information
                </p>
            </div>

            <!-- Profile Card -->
            <div class="rounded bg-white p-6 shadow">
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-600 text-xl font-semibold text-white"
                    >
                        {{ user.name.charAt(0) }}
                    </div>

                    <div>
                        <h2 class="text-lg font-medium">{{ user.name }}</h2>
                        <p class="text-sm text-gray-500">{{ user.email }}</p>
                        <span
                            class="mt-1 inline-block rounded bg-gray-100 px-2 py-0.5 text-xs font-medium capitalize"
                        >
                            {{ user.role }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Update Profile -->
            <div class="rounded bg-white p-6 shadow">
                <h3 class="mb-4 text-lg font-medium">Update Information</h3>

                <form
                    @submit.prevent="form.put('/profile')"
                    class="grid gap-4 sm:grid-cols-2"
                >
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                            >Name</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                        <p
                            v-if="form.errors.name"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                            >Email</label
                        >

                        <input
                            v-model="form.email"
                            type="email"
                            class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                        <p
                            v-if="form.errors.email"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50"
                        >
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="rounded bg-white p-6 shadow">
                <h3 class="mb-4 text-lg font-medium">Change Password</h3>
                <form
                    @submit.prevent="
                        updatePasswordForm.put('/profile/password')
                    "
                >
                    <div class="grid gap-4 sm:grid-cols-3">
                        <input
                            v-model="updatePasswordForm.current_password"
                            type="password"
                            placeholder="Current"
                            class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                        <input
                            v-model="updatePasswordForm.password"
                            type="password"
                            placeholder="New"
                            class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                        <input
                            v-model="updatePasswordForm.password_confirmation"
                            type="password"
                            placeholder="Confirm"
                            class="w-full rounded border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <div v-if="updatePasswordForm.errors">
                        <p
                            v-if="updatePasswordForm.errors.current_password"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ updatePasswordForm.errors.current_password }}
                        </p>
                        <p
                            v-if="updatePasswordForm.errors.password"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ updatePasswordForm.errors.password }}
                        </p>
                        <p
                            v-if="
                                updatePasswordForm.errors.password_confirmation
                            "
                            class="mt-1 text-sm text-red-600"
                        >
                            {{
                                updatePasswordForm.errors.password_confirmation
                            }}
                        </p>
                    </div>
                    <button
                        type="submit"
                        :disabled="updatePasswordForm.processing"
                        class="mt-4 rounded bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200"
                    >
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </CustomerLayout>
</template>
