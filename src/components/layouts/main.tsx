import {cn} from '@/lib/utils'
import {PropsWithChildren} from 'react'

type Props = {
    condensed?: boolean
} & PropsWithChildren

export default function Main(props: Props) {
    const {
        children,
        condensed,
    } = props

    return (
        <main
            className={cn(
                'w-[960px] mx-auto mt-4 py-6 px-4',
                'grow inline-flex flex-col',
                condensed && 'justify-center items-center',
            )}>
            {children}
        </main>
    )
}
