import Layout from '@/components/layouts/layout.tsx'
import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import RosterFront from './components/roster-front'
import {RosterContext, RosterContextType} from './lib/context'
import '@/roster.css'

declare global {
    const rosterVars: RosterContextType
}

createRoot(document.getElementById('bokja-roster-root')!).render(
    <StrictMode>
        <RosterContext.Provider value={rosterVars}>
            <Layout>
                <RosterFront />
            </Layout>
        </RosterContext.Provider>
    </StrictMode>,
)
