import LayoutCentered from '@/components/layouts/layout-centered'
import Layout from '@/components/layouts/layout.tsx'
import Archive from '@/components/pages/archive.tsx'
import MonthlyOverview from '@/components/pages/monthly-overview'
import Loading from '@/components/parts/loading'
import TitleMenu from '@/components/parts/title-menu'
import {RosterContext} from '@/lib/context'
import {useRosterReducer} from '@/lib/reducer'
import {getDefaultState} from '@/lib/utils'

const param = new URLSearchParams(window.location.search)

export default function RosterFront() {
    const [state, dispatch] = useRosterReducer(getDefaultState({
        ...rosterVars,
        siteParams: {
            menu: 'monthly-overview' === param.get('menu') ? 'monthly-overview' : 'roster',
            orderby: param.get('orderby') ?? 'entrance',
            order: param.get('order') ?? 'asc',
            p: parseInt(param.get('p') ?? '0') || 0,
            perpage: parseInt(param.get('p') ?? '50') || 50,
            page: parseInt(param.get('page') ?? '1') || 1,
            search: param.get('search') ?? '',
        },
    }))

    const menu = state.siteParams.menu

    return (
        <RosterContext.Provider value={{dispatch, state}}>
            {state.layout.showLoading && (
                <LayoutCentered>
                    <Loading show={true} />
                </LayoutCentered>
            )}
            <Layout>
                <TitleMenu />
                {'roster' === menu && <Archive />}
                {'monthly-overview' === menu && <MonthlyOverview />}
            </Layout>
        </RosterContext.Provider>
    )
}
