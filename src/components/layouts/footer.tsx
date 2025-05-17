import {cn} from '@/lib/utils'
import {forwardRef, type HTMLAttributes} from 'react'

const Footer = forwardRef<HTMLElement, HTMLAttributes<HTMLElement>>((_, ref) => {
    return (
        <footer
            className={cn(
                'footer footer-center sm:footer-horizontal shrink-0',
                'mt-2 p-4',
                'bg-base-300 text-base-content',
            )}
            ref={ref}
        >
            <aside>
                <p>© 2025 한국순교복자성직수도회</p>
            </aside>
        </footer>
    )
})

Footer.displayName = 'Footer'

export default Footer
