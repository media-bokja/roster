import {cn} from '@/lib/utils.ts'
import {PropsWithChildren, useRef} from 'react'
import Footer from './footer.tsx'
import Header from './header.tsx'
import Main from './main.tsx'

type Props = PropsWithChildren

export default function Layout(props: Props) {
    const {
        children,
    } = props

    const headerRef = useRef<HTMLElement>(null),
        footerRef = useRef<HTMLElement>(null)

    return (
        <>
            <div
                className={cn(
                    'layout-default',
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
