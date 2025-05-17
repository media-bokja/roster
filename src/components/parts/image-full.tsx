import type {Profile} from '@/lib/types'
import {cn} from '@/lib/utils'
import {useEffect} from 'react'

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

    useEffect(() => {
        const callback = (e: Event) => {
            e.preventDefault()
            e.stopPropagation()
            onClose && onClose()
        }

        document.body.addEventListener('roster:escape', callback)

        return () => {
            document.body.removeEventListener('roster:escape', callback)
        }
    }, [])

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
                    title={'이미지를 클릭하거나 ESC 키를 누르면 닫힙니다.'}
                    width={full.width}
                />
            </div>
        </div>
    )
}
