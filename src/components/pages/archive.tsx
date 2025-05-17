import Dialog from '@/components/pages/dialog'
import useRosterQuery from '@/components/pages/use-roster-query'
import {ImageFull} from '@/components/parts/image-full'
import ItemsGrid from '@/components/parts/items-grid.tsx'
import PageTitle from '@/components/parts/page-title.tsx'
import ToolAreaBottom from '@/components/parts/tool-area-bottom.tsx'
import ToolAreaTop from '@/components/parts/tool-area-top.tsx'
import useRosterContext from '@/lib/context'
import {ActionType} from '@/lib/reducer'
import {useState} from 'react'

export default function Archive() {
    const {
        dispatch,
        state: {
            sitemeta: {
                pageTitle,
            },
            siteParams,
        },
    } = useRosterContext()

    const {data} = useRosterQuery()

    const [showPopup, setShowPopup] = useState<boolean>(false)

    if (!data) {
        return null
    }

    return (
        <>
            <PageTitle title={pageTitle} />
            <ToolAreaTop
                maxPage={data.maxPage}
                total={data.total}
                onClickSearch={(search) => {
                    siteParams.page = 0
                    siteParams.search = search
                    dispatch({
                        type: ActionType.SET_SITE_PARAMS,
                        payload: siteParams,
                    })
                }}
            />
            <ItemsGrid
                items={data.result || []}
                onClickItem={(item) => {
                    siteParams.p = item.id
                    dispatch({
                        type: ActionType.SET_SITE_PARAMS,
                        payload: siteParams,
                    })
                }}
            />
            <ToolAreaBottom
                page={data.page}
                maxPage={data.maxPage}
                onClickPage={(page: number) => {
                    siteParams.page = page
                    dispatch({
                        type: ActionType.SET_SITE_PARAMS,
                        payload: siteParams,
                    })
                }}
            />
            <Dialog
                open={siteParams.p > 0}
                onClickThumbnail={() => setShowPopup(true)}
                onClose={() => {
                    siteParams.p = 0
                    dispatch({
                        type: ActionType.SET_SITE_PARAMS,
                        payload: siteParams,
                    })
                }}
                profile={data.result.find((profile) => profile.id === siteParams.p)}
            />
            <ImageFull
                open={siteParams.p > 0 && showPopup}
                onClose={() => setShowPopup(false)}
                profile={data.result.find((profile) => profile.id === siteParams.p)}
            />
        </>
    )
}
