import {PropsWithChildren} from 'react'

export default function Main(props: PropsWithChildren) {
    const {children} = props

    return (
        <main className="max-w-[960px] mx-auto mt-4 py-6 px-4">
            {children}
        </main>
    )
}
