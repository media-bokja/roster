import {cn} from '@/lib/utils.ts'

type Props = {
    size?: 1 | 2 | 3 | 4 | 5
    title: string
}

export default function PageTitle(props: Props) {
    const className = 'text-2xl font-bold',
        size = props.size ?? 1,
        title = props.title

    switch (size) {
        default:
            return <h1 className={cn(className)}>{title}</h1>
        case 2:
            return <h2 className={cn(className)}>{title}</h2>
        case 3:
            return <h3 className={cn(className)}>{title}</h3>
        case 4:
            return <h4 className={cn(className)}>{title}</h4>
        case 5:
            return <h5 className={cn(className)}>{title}</h5>
    }
}
