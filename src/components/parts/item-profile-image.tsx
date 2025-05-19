import {type Profile} from '@/lib/types.ts'
import {cn} from '@/lib/utils'

type Props = {
    profile: Profile
}

export default function ItemProfileImage(props: Props) {
    const {
        profile: {
            name,
            baptismalName,
            profileImage,
            isNew,
        },
    } = props
    return (
        <figure className="relative">
            {'thumbnail' in profileImage && (
                <img
                    alt={`${name} ${baptismalName}} 프로필 섬네일 이미지`}
                    className="w-full h-full object-cover"
                    src={profileImage.thumbnail.path.length ? profileImage.thumbnail.path : undefined}
                    title={`${name} ${baptismalName}} 프로필 섬네일 이미지`}
                    width={profileImage.thumbnail.width}
                    height={profileImage.thumbnail.height}
                />
            )}
            {isNew && (
                <div
                    className={cn(
                        'badge badge-secondary',
                        'text-[0.7rem] px-2 py-0',
                        'absolute top-1.5 right-1.5',
                    )}
                >
                    신규
                </div>
            )}
        </figure>
    )
}
