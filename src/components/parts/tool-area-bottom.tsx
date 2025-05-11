import Pagination from '@/components/parts/pagination'

type Props = {
    maxPage?: number
    page?: number
    onClickPage?: (page: number) => void
}

export default function ToolAreaBottom(props: Props) {
    return (
        <div className="mt-12">
            <Pagination
                maxPage={props.maxPage}
                page={props.page}
                onClickPage={props.onClickPage}
            />
        </div>
    )
}
