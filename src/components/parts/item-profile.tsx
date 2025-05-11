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
            {'thumbnail' in item.profileImage ? (
                <a
                    href={'#'}
                    onClick={(e) => {
                        e.preventDefault()
                        onClickItem && onClickItem(item)
                    }}
                >
                    <ItemProfileImage profile={item} />
                </a>
            ) : ('')}
            <div className="card-body px-2 py-4">
                <a
                    href={'#'}
                    onClick={(e) => {
                        e.preventDefault()
                        onClickItem && onClickItem(item)
                    }}
                >
                    <h2 className="card-title text-base">
                        {item.name}
                        {' '}
                        {item.baptismalName}
                    </h2>
                </a>
                <p>
                    {[item.birthday.length ? `${item.birthday}생` : '', item.currentAssignment]
                        .filter((str: string) => str.length > 0)
                        .join(', ')}
                </p>
            </div>
        </div>
    )
}