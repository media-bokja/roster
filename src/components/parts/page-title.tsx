import {cn} from '@/lib/utils.ts'
import type {HTMLAttributes} from 'react'

type Props = HTMLAttributes<HTMLHeadingElement> & {
    size?: 1 | 2 | 3 | 4 | 5
    title: string
}

export default function PageTitle(props: Props) {
    const {
        className: givenClassName,
        size: givenSize,
        title,
        ...rest
    } = props

    const className = cn('text-2xl font-bold', givenClassName),
        size = givenSize ?? 1

    switch (size) {
        default:
            return <h1 className={cn(className)} {...rest}>{title}</h1>
        case 2:
            return <h2 className={cn(className)} {...rest}>{title}</h2>
        case 3:
            return <h3 className={cn(className)} {...rest}>{title}</h3>
        case 4:
            return <h4 className={cn(className)} {...rest}>{title}</h4>
        case 5:
            return <h5 className={cn(className)} {...rest}>{title}</h5>
    }
}
