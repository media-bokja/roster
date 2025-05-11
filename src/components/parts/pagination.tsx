import {cn} from '@/lib/utils'

type Props = {
    maxPage?: number
    page?: number
    size?: number
    onClickPage?: (page: number) => void
}

export default function Pagination(props: Props) {
    const {
        maxPage,
        page,
        onClickPage,
        size = 5,
    } = props

    if (!maxPage || maxPage < 1 || !page || page < 1 || page > maxPage) {
        return null
    }

    const sector = Math.floor((page - 1) / size),
        beg = size * sector,
        end = Math.min(maxPage, size * (sector + 1)),
        range = Array.from({length: end - beg}, (_, i) => i + beg + 1),
        onClick = (p: number) => onClickPage && onClickPage(p)

    return (
        <section className="flex justify-center">
            <div className="join">
                {page > 1 && <button className="join-item btn" onClick={() => onClick(page - 1)}>«</button>}
                {range.map((p) => (
                    <button
                        className={cn('join-item btn', {'btn-active': p === page})}
                        key={p}
                        onClick={() => onClick(p)}
                    >
                        {p}
                    </button>
                ))}
                {page < maxPage && <button className="join-item btn" onClick={() => onClick(page + 1)}>»</button>}
            </div>
        </section>
    )
}
