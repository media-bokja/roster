import {type Profile} from '@/lib/types.ts'
import {cn, getThumbnailImage} from '@/lib/utils'

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

    const {
        transparent,
        props: imgProps,
    } = getThumbnailImage(profileImage)

    return (
        <figure
            className={cn(
                'relative',
                'bg-neutral-100 dark:bg-neutral-800 rounded',
            )}
        >
            <img
                alt={`${name} ${baptismalName} 프로필 섬네일 이미지`}
                className={cn(
                    'w-auto h-[192px] object-cover',
                    {'opacity-50': transparent},
                )}
                title={`${name} ${baptismalName}} 프로필 섬네일 이미지`}
                {...imgProps}
            />
            {isNew && (
                <div
                    className={cn(
                        'badge badge-secondary',
                        'text-[0.7rem] px-2 py-0',
                        'absolute top-1 right-1',
                    )}
                >
                    신규
                </div>
            )}
        </figure>
    )
}
