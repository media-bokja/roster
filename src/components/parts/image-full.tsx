import type {Profile} from '@/lib/types'
import {cn} from '@/lib/utils'

type Props = {
    open?: boolean
    onClose?: () => void
    profile?: Profile
}

export function ImageFull(props: Props) {
    const {
        open,
        onClose,
        profile,
    } = props

    if (!open || !profile || !('full' in profile.profileImage)) {
        return null
    }

    const full = profile.profileImage.full

    return (
        <div
            className={cn(
                'image-full',
                'w-screen h-screen fixed top-0 left-0 bg-black/70 z-9999',
                'flex justify-center items-center',
            )}
        >
            <div
                className="image-full-inner cursor-pointer"
                onClick={() => onClose && onClose()}
            >
                <img
                    alt={`${profile.name}의 프로필 이미지`}
                    className="w-full h-full object-cover"
                    height={full.height}
                    src={full.path}
                    width={full.width}
                />
            </div>
        </div>
    )
}
