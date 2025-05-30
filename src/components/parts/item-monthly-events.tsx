import type {Profile} from '@/lib/types'
import {cn, getThumbnailImage} from '@/lib/utils'

type Props = {
    className?: string
    field?: string
    fieldLabel?: string
    items: Profile[]
    label: string
    noItemsText?: string
    onClickItem?: (item: Profile) => void
    valueFunc?: (item: Profile) => string
}

export default function ItemMonthlyEvents(props: Props) {
    const {
        className,
        field,
        fieldLabel,
        items,
        onClickItem,
        noItemsText,
        label,
    } = props

    const valueFunc = props.valueFunc ?? ((item: Profile) => field && (field in item) ? item[field as keyof Profile].toString() : '')

    return (
        <ul className={cn('list bg-base-100 rounded-box shadow-md', className)}>
            <li className="p-4 pb-2 text-lg font-bold opacity-70 tracking-wide">
                {label}
            </li>
            {0 === items.length && (
                <li className="list-row">
                    {noItemsText ?? '해당 명단이 없습니다.'}
                </li>
            )}
            {0 < items.length && items.map((item) => {
                const {
                    transparent,
                    props: imgProps,
                } = getThumbnailImage(item.profileImage)

                return (
                    <li key={item.id} className="list-row">
                        <figure
                            className="flex relative overflow-hidden w-[72px] h-[72px] rounded-box cursor-pointer"
                            onClick={() => onClickItem && onClickItem(item)}
                        >
                            <img
                                alt={`${item.name} ${item.baptismalName} 프로필 섬네일`}
                                className={cn(
                                    "w-full h-auto object-cover",
                                    {'opacity-50': transparent},
                                )}
                                title={`${item.name} ${item.baptismalName} 프로필 섬네일`}
                                {...imgProps}
                            />
                        </figure>
                        <div className="list-col-grow">
                            <div
                                className="text-md font-semibold cursor-pointer hover:text-primary dark:hover:text-accent"
                                onClick={() => onClickItem && onClickItem(item)}
                            >
                                {item.name} {item.baptismalName}
                            </div>
                            <div className="text-sm opacity-80">
                                {!!field && !!fieldLabel && (
                                    <p>{fieldLabel}: {valueFunc(item)}</p>
                                )}
                                {item.dateOfDeath.length > 0 && <p>선종일: {item.dateOfDeath}</p>}
                            </div>
                        </div>
                    </li>
                )
            })}
        </ul>
    )
}