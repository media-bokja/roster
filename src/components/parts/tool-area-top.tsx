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
        search,
        orderby,
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
                    전체 <span>{maxPage ?? 0}</span> 페이지, <span>{total ?? 0}</span> 항목
                </div>
                <div className="flex sm:ms-4">
                    <div className="">
                        <label
                            className={cn(
                                'input max-w-64',
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
                    </div>
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
                    className="select select-ghost select-md w-2/12"
                    onChange={(e) => {
                        const value = (e.target as HTMLSelectElement).value
                        dispatch({
                            type: ActionType.SET_SITE_PARAMS,
                            payload: {
                                ...siteParams,
                                orderby: value,
                                order: 'date' === value ? 'desc' : 'asc',
                            },
                        })
                    }}
                    value={orderby}
                >
                    <option disabled={true}>정렬 순서</option>
                    <option value="date">등록일 내림차순</option>
                    <option value="birthday">생일 오름차순</option>
                    <option value="name">이름 오름차순</option>
                </select>
            </section>
        </>

    )
}