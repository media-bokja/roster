
import {initApi} from '@/lib/api.ts'
import type {RosterState} from '@/lib/types'
import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import RosterFront from './components/roster-front'

import '@/roster.css'

declare global {
    const rosterVars: RosterState & {
        api: {
            baseUrl: string
            nonce: string
        }
    }
}

initApi(rosterVars.api.baseUrl, rosterVars.api.nonce)


createRoot(document.getElementById('bokja-roster-root')!).render(
    <StrictMode>
        <RosterFront />
    </StrictMode>,
)
