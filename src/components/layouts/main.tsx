import {cn} from '@/lib/utils'
import {PropsWithChildren} from 'react'

export default function Main(props: PropsWithChildren) {
    const {children} = props

    return (
        <main
            className={cn(
                'max-w-[960px] mx-auto mt-4 py-6 px-4',
                'grow inline-flex flex-col justify-center',
            )}>
            {children}
        </main>
    )
}
