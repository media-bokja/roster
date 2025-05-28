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
                        <p className="" title="생일">생일: {item.birthday}</p>
                    )}
                    {item.currentAssignment.length > 0 && (
                        <p className="" title="현소임지">현소임지: {item.currentAssignment}</p>
                    )}
                </div>
            </div>
        </div>
    )
}