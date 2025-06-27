import useRosterContext from '@/lib/context'
import {ProfileImage, type RosterState, type SiteParams} from '@/lib/types'
import {type ClassValue, clsx} from 'clsx'
import {twMerge} from 'tailwind-merge'

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

export function getDefaultState(override: Partial<RosterState> = {}): RosterState {
    return {
        layout: {
            showLoading: false,
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
            menu: 'roster',
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

export function getThumbnailImage(profileImage: { [key: string]: ProfileImage }) {
    const {
        state: {
            sitemeta: {
                placeholderImage,
            },
        },
    } = useRosterContext()

    let src: string | undefined,
        width: number | undefined,
        height: number | undefined,
        transparent: boolean | undefined

    if (profileImage && 'medium' in profileImage) {
        src = profileImage.medium.path
        width = profileImage.medium.width
        height = profileImage.medium.height
        transparent = false
    }

    if (!src || 0 === src.length) {
        src = placeholderImage
        width = 240
        height = 240
        transparent = true
    }

    return {
        transparent,
        props: {
            src,
            width,
            height,
        },
    }
}

export function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    })
}
