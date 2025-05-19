import type {RosterLayout, RosterState, SiteParams} from '@/lib/types'
import {setHistory} from '@/lib/utils'
import {useReducer} from 'react'

enum ActionType {
    SET_LAYOUT = 'setLayout',
    SET_SITE_PARAMS = 'setSiteParams',
    SET_THEME = 'setTheme',
}

type Action =
    | { type: ActionType.SET_LAYOUT, payload: RosterLayout }
    | { type: ActionType.SET_SITE_PARAMS, payload: SiteParams }
    | { type: ActionType.SET_THEME, payload: string }

function reducer(prevState: RosterState, action: Action): RosterState {
    const {payload, type} = action

    switch (type) {
        case ActionType.SET_LAYOUT:
            return {
                ...prevState,
                layout: payload,
            }

        case ActionType.SET_SITE_PARAMS:
            setHistory(payload)
            return {
                ...prevState,
                siteParams: payload,
            }

        case ActionType.SET_THEME:
            document.getElementsByTagName('html')![0].setAttribute('data-theme', payload)
            return {
                ...prevState,
                sitemeta: {
                    ...prevState.sitemeta,
                    theme: payload,
                },
            }

        default:
            return prevState
    }
}

const useRosterReducer = (initialState: RosterState) => {
    return useReducer<RosterState, [action: Action]>(reducer, initialState)
}

export type {
    Action,
}

export {
    ActionType,
    reducer,
    useRosterReducer,
}
