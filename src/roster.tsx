import Layout from '@/components/layouts/layout.tsx'
import {initApi} from '@/lib/api.ts'
import {QueryClient, QueryClientProvider} from '@tanstack/react-query'
import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import RosterFront from './components/roster-front'
import {getDefaultContext, RosterContext, RosterContextType} from './lib/context'
import '@/roster.css'

declare global {
    const rosterVars: RosterContextType & {
        api: {
            baseUrl: string
            nonce: string
        }
    }
}

initApi(rosterVars.api.baseUrl, rosterVars.api.nonce)

const queryClient = new QueryClient()

createRoot(document.getElementById('bokja-roster-root')!).render(
    <StrictMode>
        <QueryClientProvider client={queryClient}>
            <RosterContext.Provider value={getDefaultContext(rosterVars)}>
                <Layout>
                    <RosterFront />
                </Layout>
            </RosterContext.Provider>
        </QueryClientProvider>
    </StrictMode>,
)
