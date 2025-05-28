import ItemProfileImage from '@/components/parts/item-profile-image'
import {type Profile} from '@/lib/types.ts'
import {cn} from '@/lib/utils'

type Props = {
    item: Profile
    onClickItem?: (item: Profile) => void
}

export default function ItemProfile(props: Props) {
    const {
        item,
        onClickItem,
    } = props

    return (
        <div className="card card-border bg-base-100">
            <a
                href={'#'}
                onClick={(e) => {
                    e.preventDefault()
                    onClickItem && onClickItem(item)
                }}
            >
                <ItemProfileImage profile={item} />
            </a>
            <div className="card-body px-2 py-4">
                <a
                    href={'#'}
                    onClick={(e) => {
                        e.preventDefault()
                        onClickItem && onClickItem(item)
                    }}
                >
                    <h2 className="card-title text-base hover:text-primary dark:hover:text-accent">
                        {item.name}
                        {' '}
                        {item.baptismalName}
                    </h2>
                </a>
                <div className="leading-5">
                    {item.birthday.length > 0 && (
                        <p title="생일">
                            <span
                                className={cn(
                                    'font-medium after:content-[":"]',
                                )}
                            >생일</span> {item.birthday}
                        </p>
                    )}
                    {item.dateOfDeath.length > 0 && (
                        <p title="선종일">
                            <span
                                className={cn(
                                    'font-medium after:content-[":"]',
                                )}
                            >선종일</span> {item.dateOfDeath}
                        </p>
                    )}
                    {item.dateOfDeath.length === 0 && item.currentAssignment.length > 0 && (
                        <p title="현소임지">
                            <span
                                className={cn(
                                    'font-medium after:content-[":"]',
                                )}
                            >현소임지</span> {item.currentAssignment}
                        </p>
                    )}
                </div>
            </div>
        </div>
    )
}