import {cn} from '@/lib/utils'
import {PropsWithChildren} from 'react'

type Props = PropsWithChildren

export default function Main(props: Props) {
    const {
        children,
    } = props

    return (
        <main
            className={cn(
                'w-full lg:w-[1092px]',
                'mx-auto mt-4 py-6 px-4',
                'grow inline-flex flex-col',
            )}
        >
            {children}
        </main>
    )
}
