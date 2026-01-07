import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

/**
 * Car interface (matches Laravel response)
 */
export interface Car {
    id: number;
    brand: string;
    model: string;
    plate_number: string;
    price_per_day: number;
    description?: string;
    image_url?: string;
    status: 'available' | 'maintenance' | 'rented';
    is_available: boolean;
    category?: Category;
    images?: CarImage[];
    price_daily: number;
    price_weekly: number;
    price_monthly: number;
    category: Category;
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface Paginated<T> {
    data: T[];
    links: PaginationLink[];
}

export interface CarImage {
    id: number;
    car_id: number;
    path: string;
    is_primary: boolean;
}

export interface Category {
    name: string;
    slug?: string;
    is_active: boolean;
    id: number;
}

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
    children?: NavItem[];
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    is_active?: boolean;
    role: 'admin' | 'staff' | 'user';
}

export type Invoice = {
    id: number;
    invoice_number: string;
    car: string;
    total_price: number;
    payment_status: string;
    created_at: string;
    tatal_days: number;
};

export interface Payment {
    id: number;
    car: string;
    plate: string;
    total_price: number;
    payment_status: 'PAID' | 'PENDING';
    payment_method: string;
    paid_at?: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
export type Booking = {
    id: number;
    invoiceUrl?: string;
    paymentStatus: PaymentStatus;
    payment_status: PaymentStatus;
    carName: string;
    startDate: string;
    endDate: string;
    total: number;
    plate?: string;
    image?: string;
    pickupLocation?: string;
    pickup_location?: string;
    status: BookingStatus;
    priceType: 'daily' | 'weekly' | 'monthly';
    car: Car;
    user: User;
    end_date: string;
    start_date: string;
};

export type MyBooking = {
    id: number;
    carName: string;
    image: string;
    plate: string;
    startDate: string;
    endDate: string;
    total: number;
    status: BookingStatus;
    pickupLocation: string;
    paymentStatus?: PaymentStatus;
    invoice_url?: string;
    priceType: 'daily' | 'weekly' | 'monthly';
};

export type Review = {
    id: number;
    user_id: number;
    car_id: number;
    rating: number;
    comment: string;
    created_at?: string;
    updated_at?: string;
};

export type PaymentStatus = 'PAID' | 'PENDING';
export type BookingStatus = 'BOOKED' | 'ONGOING' | 'RETURNED' | 'CANCELLED';
