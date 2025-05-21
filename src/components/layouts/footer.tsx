import useRosterContext from '@/lib/context'
import {cn} from '@/lib/utils'
import {forwardRef, type HTMLAttributes} from 'react'

const Footer = forwardRef<HTMLElement, HTMLAttributes<HTMLElement>>((_, ref) => {
    const {
        state: {
            sitemeta: {
                version,
            },
        },
    } = useRosterContext()

    return (
        <footer
            className={cn(
                'relative',
                'footer footer-center sm:footer-horizontal',
                'mt-2 p-4',
                'shrink-0',
                'bg-base-300 text-base-content',
            )}
            ref={ref}
        >
            <aside>
                <p>© 2025 한국순교복자성직수도회</p>
                <p className="absolute bottom-1 right-2 text-xs italic">Ver.{version}</p>
            </aside>
        </footer>
    )
})

Footer.displayName = 'Footer'

export default Footer
