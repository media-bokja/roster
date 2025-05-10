import useRosterContext from '@/lib/context.ts'

type Props = {
    title?: string
}

export default function PageTitle(props: Props) {
    const {
        sitemeta: {
            pageTitle,
        },
    } = useRosterContext()

    const {
        title,
    } = props

    return (
        <h1 className="text-2xl font-bold">
            {title ?? pageTitle}
        </h1>
    )
}
