import {cn} from '@/lib/utils'
import {PropsWithChildren} from 'react'

type Props = PropsWithChildren

export default function MainCentered(props: Props) {
    const {
        children,
    } = props

    return (
        <main
            className={cn(
                'w-[960px]',
                'mx-auto mt-4 py-6 px-4',
                'grow inline-flex flex-col',
                'justify-center items-center',
            )}
        >
            {children}
        </main>
    )
}
