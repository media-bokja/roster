import type {RosterState, SiteParams} from '@/lib/types'
import {type ClassValue, clsx} from 'clsx'
import {twMerge} from 'tailwind-merge'

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

export function getDefaultState(override: Partial<RosterState> = {}): RosterState {
    return {
        layout: {
            condensed: false,
            showLoading: false,
            verticalCenter: false,
        },
        sitemeta: {
            homeUrl: '',
            pageTitle: '',
            placeholderImage: '',
            profileAdminUrl: '',
            rosterAdminUrl: '',
            siteIcon: '',
            siteTitle: '',
            siteUrl: '',
            theme: 'light',
            userAvatar: '',
            userName: '',
            version: '',
            ...override.sitemeta,
        },
        siteParams: {
            p: 0,
            page: 0,
            perpage: 50,
            search: '',
            orderby: 'entrance',
            order: 'asc',
            ...override.siteParams,
        },
        ...override,
    }
}

export function setHistory(params: SiteParams) {
    const url = new URL(window.location.href)

    for (const [key, value] of Object.entries(params)) {
        url.searchParams.set(key, value.toString())
    }

    window.history.pushState({}, '', url.href)
}

export function getThemeName(dark: boolean): string {
    return dark ? 'dark' : 'light'
}
