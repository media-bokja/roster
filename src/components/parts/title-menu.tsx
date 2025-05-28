import PageTitle from '@/components/parts/page-title'
import useRosterContext from '@/lib/context'
import {ActionType} from '@/lib/reducer'
import {cn} from '@/lib/utils'

export default function TitleMenu() {
    const {
        dispatch,
        state: {
            sitemeta: {
                pageTitle,
            },
            siteParams,
        },
    } = useRosterContext()

    const {
        menu,
    } = siteParams

    return (
        <div
            className={cn(
                'flex gap-x-3',
            )}
        >
            <PageTitle
                className={cn(
                    'roster' === menu ? 'text-base-content' : 'text-neutral-400',
                    'cursor-pointer',
                )}
                onClick={() => {
                    console.log('roster')
                    dispatch({
                        type: ActionType.SET_SITE_PARAMS,
                        payload: {
                            ...siteParams,
                            menu: 'roster',
                        },
                    })
                }}
                title={pageTitle}
            />
            <PageTitle
                className={cn(
                    'monthly-overview' === menu ? 'text-base-content' : 'text-neutral-400',
                    'before:text-base-content before:content-["|"] before:me-2.5',
                    'cursor-pointer',
                )}
                onClick={() => {
                    console.log('monthly-overview')
                    dispatch({
                        type: ActionType.SET_SITE_PARAMS,
                        payload: {
                            ...siteParams,
                            menu: 'monthly-overview',
                        },
                    })
                }}
                title={'기념일'}
            />
        </div>
    )
}
