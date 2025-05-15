import Layout from '@/components/layouts/layout.tsx'
import Archive from '@/components/pages/archive.tsx'
import {RosterContext} from '@/lib/context'
import {useRosterReducer} from '@/lib/reducer'
import {getDefaultState} from '@/lib/utils'
import {QueryClient, QueryClientProvider} from '@tanstack/react-query'

const param = new URLSearchParams(window.location.search)
const queryClient = new QueryClient()

export default function RosterFront() {
    const [state, dispatch] = useRosterReducer(getDefaultState({
        ...rosterVars,
        siteParams: {
            p: parseInt(param.get('p') ?? '0') || 0,
            page: parseInt(param.get('page') ?? '1') || 1,
            search: param.get('search') ?? '',
        },
    }))

    return (
        <QueryClientProvider client={queryClient}>
            <RosterContext.Provider value={{dispatch, state}}>
                <Layout>
                    <Archive />
                </Layout>
            </RosterContext.Provider>
        </QueryClientProvider>
    )
}
