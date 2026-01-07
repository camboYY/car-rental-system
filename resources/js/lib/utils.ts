import { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export const formatDate = (date: string) => {
    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date));
};

export function urlIsActive(
    urlToCheck: NonNullable<InertiaLinkProps['href']>,
    currentUrl: string,
) {
    return currentUrl === urlToCheck || currentUrl.startsWith(`${urlToCheck}/`);

    // return toUrl(urlToCheck) === currentUrl;
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}

// Status badge styling
export const statusClass = (status: string) => {
    switch (status) {
        case 'BOOKED':
            return 'bg-blue-100 text-blue-700';
        case 'ONGOING':
            return 'bg-yellow-100 text-yellow-700';
        case 'RETURNED':
            return 'bg-green-100 text-green-700';
        case 'CANCELLED':
            return 'bg-red-100 text-red-700';
        default:
            return 'bg-gray-100 text-gray-700';
    }
};

export function isActive(match: string[], currentUrl: string): boolean {
    return match.some((path) => currentUrl.startsWith(path));
}
