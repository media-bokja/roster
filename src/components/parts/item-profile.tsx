import HighlightSearch from '@/components/parts/highlight-search'
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
            <div className="card-body px-2 py-1 gap-y-1">
                <a
                    href={'#'}
                    onClick={(e) => {
                        e.preventDefault()
                        onClickItem && onClickItem(item)
                    }}
                >
                    <h2 className="card-title text-base hover:text-primary break-keep tracking-tight dark:hover:text-accent">
                        <HighlightSearch text={item.name} />
                        {' '}
                        <HighlightSearch text={item.baptismalName} />
                    </h2>
                </a>
                <div className="leading-5">
                    {item.birthday.length > 0 && (
                        <p className="tracking-tight" title="생일">
                            <span className="shrink">{item.birthday}</span> 생
                        </p>
                    )}
                    {item.dateOfDeath.length > 0 && (
                        <p className="tracking-tight" title="선종일">
                            <span className="shrink">{item.dateOfDeath}</span> 선종
                        </p>
                    )}
                    {item.dateOfDeath.length === 0 && item.currentAssignment.length > 0 && (
                        <p title="현소임지" className="">
                            <span className="shrink overflow-hidden break-keep tracking-tighter">
                                <HighlightSearch text={item.currentAssignment} /></span>
                        </p>
                    )}
                </div>
            </div>
        </div>
    )
}