import {SiteMeta} from '@/lib/types.ts'
import {createContext, useContext} from 'react'

type RosterContextType = {
    sitemeta: SiteMeta
    showLoading: boolean
}

const getDefaultContext = (override: Partial<RosterContextType> = {}): RosterContextType => ({
    sitemeta: {
        avatarUrl: '',
        homeUrl: '',
        pageTitle: '',
        siteIcon: '',
        siteTitle: '',
        siteUrl: '',
        userAvatar: '',
        userName: '',
        ...override.sitemeta,
    },
    showLoading: false,
    ...override,
})

const RosterContext = createContext(getDefaultContext())

const useRosterContext = () => {
    return useContext(RosterContext)
}

export default useRosterContext

export {
    getDefaultContext,
    RosterContext,
}

export type {
    RosterContextType,
}