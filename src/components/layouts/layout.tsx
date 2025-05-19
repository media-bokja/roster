import useRosterContext from '@/lib/context'
import {PropsWithChildren, useRef} from 'react'
import Footer from './footer.tsx'
import Header from './header.tsx'
import Main from './main.tsx'
import {cn} from '@/lib/utils.ts'

type Props = PropsWithChildren

export default function Layout(props: Props) {
    const {
        children,
    } = props

    const {
        state: {
            layout: {
                condensed,
            },
        },
    } = useRosterContext()

    const headerRef = useRef<HTMLElement>(null),
        footerRef = useRef<HTMLElement>(null)

    return (
        <>
            <div
                className={cn(
                    condensed ? 'layout-condensed' : 'layout-default',
                    'min-h-screen',
                    'flex flex-col',
                )}
                onKeyUpCapture={(e) => {
                    if ('Escape' === e.key) {
                        document.body.dispatchEvent(new CustomEvent('roster:escape', {}))
                    }
                }}
            >
                <Header ref={headerRef} />
                <Main>{children}</Main>
                <Footer ref={footerRef} />
            </div>
        </>
    )
}
