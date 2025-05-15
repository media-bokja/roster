import type {RosterState, SiteParams} from '@/lib/types'
import {type ClassValue, clsx} from 'clsx'
import {twMerge} from 'tailwind-merge'

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

export function getDefaultState(override: Partial<RosterState> = {}): RosterState {
    return {
        sitemeta: {
            homeUrl: '',
            pageTitle: '',
            profileAdminUrl: '',
            rosterAdminUrl: '',
            siteIcon: '',
            siteTitle: '',
            siteUrl: '',
            userAvatar: '',
            userName: '',
            ...override.sitemeta,
        },
        siteParams: {
            p: 0,
            page: 0,
            search: '',
            ...override.siteParams,
        },
        showLoading: false,
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
