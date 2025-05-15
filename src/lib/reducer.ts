import type {RosterState, SiteParams} from '@/lib/types'
import {setHistory} from '@/lib/utils'
import {useReducer} from 'react'

enum ActionType {
    SET_SITE_PARAMS = 'setSiteParams',
}

type Action =
    | { type: ActionType.SET_SITE_PARAMS, payload: SiteParams }

function reducer(prevState: RosterState, action: Action): RosterState {
    const {payload, type} = action

    switch (type) {
        case ActionType.SET_SITE_PARAMS:
            setHistory(payload)
            return {
                ...prevState,
                siteParams: payload,
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
