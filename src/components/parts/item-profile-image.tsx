import useRosterContext from '@/lib/context'
import {type Profile, ProfileImage} from '@/lib/types.ts'
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

    const {
        transparent,
        props: imgProps,
    } = getThumbnailImage(profileImage)

    return (
        <figure className="relative">
            <img
                alt={`${name} ${baptismalName} 프로필 섬네일 이미지`}
                className={cn(
                    'w-3/4 h-[192px] object-cover',
                    'border border-neutral-300 dark:border-neutral-700 rounded',
                    'shadow-lg',
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
                        'absolute top-1 right-0',
                    )}
                >
                    신규
                </div>
            )}
        </figure>
    )
}

const getThumbnailImage = (profileImage: { [key: string]: ProfileImage }) => {
    const {
        state: {
            sitemeta: {
                placeholderImage,
            },
        },
    } = useRosterContext()

    let src: string | undefined,
        width: number | undefined,
        height: number | undefined,
        transparent: boolean | undefined

    if (profileImage && 'thumbnail' in profileImage) {
        src = profileImage.thumbnail.path
        width = profileImage.thumbnail.width
        height = profileImage.thumbnail.height
        transparent = false
    }

    if (!src || 0 === src.length) {
        src = placeholderImage
        width = 240
        height = 240
        transparent = true
    }

    return {
        transparent,
        props: {
            src,
            width,
            height,
        },
    }
}
