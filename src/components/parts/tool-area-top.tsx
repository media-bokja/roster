import useRosterContext from '@/lib/context'
import {ActionType} from '@/lib/reducer'
import {cn} from '@/lib/utils.ts'
import {useState} from 'react'

type Props = {
    onClickSearch?: (search: string) => void
    maxPage?: number
    total?: number
}

export default function ToolAreaTop(props: Props) {
    const {
        onClickSearch,
        maxPage,
        total,
    } = props

    const {
        dispatch,
        state: {
            siteParams,
        },
    } = useRosterContext()

    const {
        page,
        perpage,
        search,
        orderby,
        order,
    } = siteParams

    const [searchText, setSearchText] = useState<string>(search)

    return (
        <>
            <section
                className={cn(
                    'mt-4',
                    'block',
                    'sm:flex sm:justify-end sm:items-center',
                )}
            >
                <div className="text-sm mt-6 mb-3 ps-1 sm:my-0">
                    전체 <span>{maxPage ?? 0}</span> 페이지,
                    {' '}<span>{total ?? 0}</span> 항목,
                    {' '}현재 <span>{Math.max(page, 1)}</span> 페이지
                </div>
                <div className="flex justify-between sm:ms-4">
                    <label
                        className={cn(
                            'input w-full md:w-56',
                            'focus:outline-0 focus:outline-base-300 focus:outline-offset-0',
                            'focus-within:outline-0 focus-within:outline-base-300 focus-within:outline-offset-0',
                        )}
                    >
                        명부 검색
                        <input
                            className="grow"
                            onChange={(e) => setSearchText(e.target.value)}
                            onKeyUp={(e) => {
                                if (e.key === 'Enter') {
                                    onClickSearch?.(searchText)
                                }
                            }}
                            placeholder="검색어, 이름, ..."
                            type="search"
                            value={searchText}
                        />
                    </label>
                    <button
                        className="ms-2 btn btn-neutral"
                        onClick={() => onClickSearch?.(searchText)}
                        type="button"
                    >
                        검색
                    </button>
                </div>
            </section>
            <section className={cn('block mt-4 w-full text-right')}>
                <select
                    className="select select-ghost select-md w-fit"
                    onChange={(e) => {
                        const [orderby, order] = (e.target as HTMLSelectElement).value.split(':', 2)

                        dispatch({
                            type: ActionType.SET_SITE_PARAMS,
                            payload: {
                                ...siteParams,
                                page: 0,
                                orderby,
                                order,
                            },
                        })
                    }}
                    value={`${orderby}:${order}`}
                >
                    <option disabled={true}>정렬 순서</option>
                    <option value="entrance:asc">입회일 오름차순</option>
                    <option value="entrance:desc">입회일 내림차순</option>
                    <option value="date:asc">등록일 오름차순</option>
                    <option value="date:desc">등록일 내림차순</option>
                    <option value="birthday:asc">생일 오름차순</option>
                    <option value="birthday:desc">생일 내림차순</option>
                    <option value="name:asc">이름 오름차순</option>
                    <option value="name:desc">이름 내림차순</option>
                </select>
                <select
                    className="select select-ghost select-md w-fit"
                    onChange={(e) => {
                        const perpage = parseInt((e.target as HTMLSelectElement).value)

                        dispatch({
                            type: ActionType.SET_SITE_PARAMS,
                            payload: {
                                ...siteParams,
                                page: 0,
                                perpage,
                            },
                        })
                    }}
                    value={perpage}
                >
                    <option disabled={true}>항목 수</option>
                    <option value={25}>25</option>
                    <option value={50}>50</option>
                    <option value={100}>100</option>
                </select>
                {maxPage && maxPage > 0 && (
                    <select
                        className="select select-ghost select-md w-fit"
                        onChange={(e) => {
                            const page = parseInt((e.target as HTMLSelectElement).value)

                            dispatch({
                                type: ActionType.SET_SITE_PARAMS,
                                payload: {
                                    ...siteParams,
                                    page,
                                },
                            })
                        }}
                        value={page}
                    >
                        <option disabled={true}>페이지</option>
                        {Array(maxPage).fill(0).map((_, i) => (
                            <option key={i} value={i + 1}>{i + 1} 페이지</option>
                        ))}
                    </select>
                )}
            </section>
        </>

    )
}