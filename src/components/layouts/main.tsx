import useRosterContext from '@/lib/context'
import {cn} from '@/lib/utils'
import {PropsWithChildren} from 'react'

type Props = PropsWithChildren

export default function Main(props: Props) {
    const {
        children,
    } = props

    const {
        state: {
            layout: {
                condensed,
                verticalCenter,
            },
        },
    } = useRosterContext()

    return (
        <main
            className={cn(
                condensed ? 'w-[960px]' : 'max-w-[960px]',
                'mx-auto mt-4 py-6 px-4',
                'grow inline-flex flex-col',
                verticalCenter && 'justify-center items-center',
            )}
        >
            {children}
        </main>
    )
}
