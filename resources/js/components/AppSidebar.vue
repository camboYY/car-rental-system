<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import admin from '@/routes/admin';
import users from '@/routes/users';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    Bus,
    CarTaxiFrontIcon,
    Folder,
    LayoutGrid,
    User,
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: admin.dashboard().url,
        icon: LayoutGrid,
    },
    {
        title: 'Cars',
        href: admin.cars.index().url,
        icon: Bus,
    },
    {
        title: 'Cateogry',
        href: admin.categories.index().url,
        icon: CarTaxiFrontIcon,
    },
    {
        title: 'Users',
        href: users.index().url,
        icon: User,
    },
    {
        title: 'Return Cars',
        href: admin.bookings.returns().url,
        icon: Bus,
    },
    {
        title: 'Pickup Cars',
        href: admin.bookings.pickups().url,
        icon: Bus,
    },
    {
        title: 'Ongoing Rentals',
        href: admin.bookings.ongoing().url,
        icon: Bus,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="admin.dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
