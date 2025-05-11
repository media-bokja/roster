import Loading from '@/components/parts/loading'
import {PropsWithChildren} from 'react'
import Footer from './footer.tsx'
import Header from './header.tsx'
import Main from './main.tsx'

export default function Layout(props: PropsWithChildren) {
    return (
        <>
            <Loading />
            <div className="layout-default">
                <Header />
                <Main>
                    {props.children}
                </Main>
                <Footer />
            </div>
        </>

    )
}
