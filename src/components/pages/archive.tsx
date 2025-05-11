import Dialog from '@/components/pages/dialog'
import ItemsGrid from '@/components/parts/items-grid.tsx'
import PageTitle from '@/components/parts/page-title.tsx'
import ToolAreaBottom from '@/components/parts/tool-area-bottom.tsx'
import ToolAreaTop from '@/components/parts/tool-area-top.tsx'
import {Roster} from '@/lib/api.ts'
import {useQuery} from '@tanstack/react-query'
import {useState} from 'react'

export default function Archive() {
    const [currentId, setCurrentId] = useState<number>(0)
    const [query, setQuery] = useState<URLSearchParams>(new URLSearchParams())

    const {data} = useQuery({
        queryKey: ['roster', 'get', query.toString()],
        queryFn: () => {
            return Roster.query(query.toString())
        },
    })

    return (
        <>
            <PageTitle title={'명단 목록'} />
            <ToolAreaTop
                maxPage={data?.maxPage}
                total={data?.total}
                onClickSearch={(search) => {
                    setQuery((prevState) => {
                        const nextState = new URLSearchParams(prevState)
                        nextState.set('search', search.trim())
                        return nextState
                    })
                }}
            />
            <ItemsGrid
                items={data?.result || []}
                onClickItem={(item) => {
                    setCurrentId(item.id)
                }}
            />
            <ToolAreaBottom
                page={data?.page}
                maxPage={data?.maxPage}
                onClickPage={(p: number) => {
                    setQuery((prevState) => {
                        const nextState = new URLSearchParams(prevState)
                        nextState.set('page', p.toString())
                        return nextState
                    })
                }}
            />
            <Dialog
                open={currentId > 0}
                onClose={() => setCurrentId(0)}
                profile={data?.result.find((profile) => profile.id === currentId)}
            />
        </>
    )
}