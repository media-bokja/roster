import {initAjax} from '@/lib/ajax'
import {initApi} from '@/lib/api.ts'
import type {Action, RosterState} from '@/lib/types'
import {QueryClient, QueryClientProvider} from '@tanstack/react-query'
import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import RosterFront from './components/roster-front'

import '@/roster.css'

declare global {
    const rosterVars: RosterState & {
        ajax: {
            actions: { [key: string]: Action }
            url: string
        }
        api: {
            baseUrl: string
            nonce: string
        }
    }
}

initAjax(rosterVars.ajax.url, rosterVars.ajax.actions)
initApi(rosterVars.api.baseUrl, rosterVars.api.nonce)

const queryClient = new QueryClient()

createRoot(document.getElementById('bokja-roster-root')!).render(
    <StrictMode>
        <QueryClientProvider client={queryClient}>
            <RosterFront />
        </QueryClientProvider>
    </StrictMode>,
)
