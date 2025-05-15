import type {Action} from '@/lib/reducer'
import type {RosterState} from '@/lib/types'
import {getDefaultState} from '@/lib/utils'
import {type ActionDispatch, createContext, useContext} from 'react'

type RosterContextType = {
    state: RosterState
    dispatch: ActionDispatch<[action: Action]>
}

const RosterContext = createContext<RosterContextType>({
    dispatch: () => {},
    state: getDefaultState(),
})

const useRosterContext = () => {
    return useContext(RosterContext)
}

export default useRosterContext

export {
    RosterContext,
}
