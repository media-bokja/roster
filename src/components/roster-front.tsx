import Layout from '@/components/layouts/layout.tsx'
import Archive from '@/components/pages/archive.tsx'
import Loading from '@/components/parts/loading'
import {RosterContext} from '@/lib/context'
import {useRosterReducer} from '@/lib/reducer'
import {getDefaultState} from '@/lib/utils'

const param = new URLSearchParams(window.location.search)

export default function RosterFront() {
    const [state, dispatch] = useRosterReducer(getDefaultState({
        ...rosterVars,
        siteParams: {
            orderby: param.get('orderby') ?? '',
            order: param.get('order') ?? '',
            p: parseInt(param.get('p') ?? '0') || 0,
            page: parseInt(param.get('page') ?? '1') || 1,
            search: param.get('search') ?? '',
        },
    }))

    return (
        <RosterContext.Provider value={{dispatch, state}}>
            <Layout>
                <Loading show={state.layout.showLoading} />
                <Archive />
            </Layout>
        </RosterContext.Provider>
    )
}
