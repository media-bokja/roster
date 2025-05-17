import {PropsWithChildren, useRef} from 'react'
import Footer from './footer.tsx'
import Header from './header.tsx'
import Main from './main.tsx'

export default function Layout(props: PropsWithChildren) {
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
                <Main>
                    {props.children}
                </Main>
                <Footer ref={footerRef} />
            </div>
        </>

    )
}
