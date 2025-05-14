import {cn} from '@/lib/utils'

export default function Footer() {
    return (
        <footer
            className={cn(
                'footer footer-center sm:footer-horizontal',
                'mt-2 p-4',
                'bg-base-300 text-base-content',
            )}
        >
            <aside>
                <p>© 2025 한국순교복자성직수도회</p>
            </aside>
        </footer>
    )
}
