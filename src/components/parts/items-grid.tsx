import ItemProfile from '@/components/parts/item-profile'
import {Profile} from '@/lib/types.ts'
import {cn} from '@/lib/utils.ts'

type Props = {
    items: Profile[]
    onClickItem?: (item: Profile) => void
}

export default function ItemsGrid(props: Props) {
    const {
        items,
        onClickItem,
    } = props

    if (0 === items.length) {
        return (
            <section className="mt-12 flex flex-col grow justify-center items-center">
                <p className="text-xl text-base-content">
                    명단을 찾을 수 없습니다.
                </p>
            </section>
        )
    }

    return (
        <section
            className={cn(
                'mt-6 min-h-[360px]',
                'grid auto-rows-auto gap-x-2 gap-y-4',
                'grid-cols-2 sm:grid-cols-4 md:grid-cols-5',
            )}
        >
            {items.map((item) => (
                <ItemProfile
                    key={item.id}
                    item={item}
                    onClickItem={onClickItem}
                />
            ))}
        </section>
    )
}