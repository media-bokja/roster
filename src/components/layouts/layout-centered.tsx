import MainCentered from '@/components/layouts/main-centered'
import {cn} from '@/lib/utils.ts'
import {PropsWithChildren, useRef} from 'react'
import Footer from './footer.tsx'
import Header from './header.tsx'

type Props = PropsWithChildren

export default function LayoutCentered(props: Props) {
    const {
        children,
    } = props

    const headerRef = useRef<HTMLElement>(null),
        footerRef = useRef<HTMLElement>(null)

    return (
        <>
            <div
                className={cn(
                    'layout-centered',
                    'h-screen',
                    'flex flex-col',
                )}
            >
                <Header ref={headerRef} />
                <MainCentered>{children}</MainCentered>
                <Footer ref={footerRef} />
            </div>
        </>
    )
}
