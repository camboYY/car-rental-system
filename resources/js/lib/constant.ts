import customer from '@/routes/customer';
import {
    Car,
    CreditCard,
    FileText,
    LayoutDashboard,
    PersonStanding,
} from 'lucide-vue-next';

export const customerMenu = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutDashboard,
        match: ['/dashboard'],
    },
    {
        title: 'Available Cars',
        href: '/cars',
        icon: Car,
        match: ['/cars'],
    },
    {
        title: 'My Bookings',
        href: '/my-bookings',
        icon: Car,
        match: ['/my-bookings', '/bookings'],
    },
    {
        title: 'Invoices',
        href: '/invoices',
        icon: FileText,
        match: ['/invoices'],
    },
    {
        title: 'Payments',
        href: '/payments',
        icon: CreditCard,
        match: ['/payments'],
    },
    {
        title: 'profile',
        href: customer.profile.edit().url,
        icon: PersonStanding,
        match: ['/customer/profile'],
    },
];
