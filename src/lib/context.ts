import {SiteMeta} from '@/lib/types.ts'
import {createContext, useContext} from 'react'

type RosterContextType = {
    sitemeta: SiteMeta
}

const getDefaultContext = () => ({
    sitemeta: {
        homeUrl: '',
        pageTitle: '',
        siteIcon: '',
        siteTitle: '',
        siteUrl: '',
        userAvatar: '',
        userName: '',
    },
})

const RosterContext = createContext(getDefaultContext())

const useRosterContext = () => {
    return useContext(RosterContext)
}

export default useRosterContext

export {
    RosterContext,
}

export type {
    RosterContextType,
}