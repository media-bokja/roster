import {PropsWithChildren, useRef} from 'react'
import Footer from './footer.tsx'
import Header from './header.tsx'
import Main from './main.tsx'

type Props = {
    condensed?: boolean
} & PropsWithChildren

export default function Layout(props: Props) {
    const {
        children,
        condensed,
    } = props

    const headerRef = useRef<HTMLElement>(null),
        footerRef = useRef<HTMLElement>(null)

    return (
        <>
            <div
                className="layout-default flex flex-col min-h-screen"
                onKeyUpCapture={(e) => {
                    if ('Escape' === e.key) {
                        document.body.dispatchEvent(new CustomEvent('roster:escape', {}))
                    }
                }}
            >
                <Header ref={headerRef} />
                <Main condensed={condensed}>{children}</Main>
                <Footer ref={footerRef} />
            </div>
        </>
    )
}
