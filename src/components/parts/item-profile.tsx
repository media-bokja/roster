import ItemProfileImage from '@/components/parts/item-profile-image'
import {type Profile} from '@/lib/types.ts'

type Props = {
    item: Profile
    onClickItem?: (item: Profile) => void
}

export default function ItemProfile(props: Props) {
    const {
        item,
        onClickItem,
    } = props

    const labelCommonClass = 'font-medium grow min-w-[58px] after:content-[":"]'

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
                        <p title="생일" className="inline-flex flex-col md:flex-row md:mt-0">
                            <span className={labelCommonClass}>생일</span>
                            <span>{item.birthday}</span>
                        </p>
                    )}
                    {item.dateOfDeath.length > 0 && (
                        <p title="선종일" className="inline-flex flex-col md:flex-row mt-2 md:mt-0">
                            <span className={labelCommonClass}>선종일</span>
                            <span>{item.dateOfDeath}</span>
                        </p>
                    )}
                    {item.dateOfDeath.length === 0 && item.currentAssignment.length > 0 && (
                        <p title="현소임지" className="inline-flex flex-col md:flex-row mt-2 md:mt-0">
                            <span className={labelCommonClass}>현소임지</span>
                            <span className="shrink break-keep">{item.currentAssignment}</span>
                        </p>
                    )}
                </div>
            </div>
        </div>
    )
}