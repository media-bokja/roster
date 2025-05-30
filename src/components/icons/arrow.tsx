import type {SVGAttributes} from 'react'

type Props = SVGAttributes<SVGElement>

function ArrowRight(props: Props) {
    return (
        <svg className={props.className} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g strokeLinejoin="round" strokeLinecap="round" strokeWidth="2" fill="none" stroke="currentColor">
                <path d="M6 3L20 12 6 21 6 3z"></path>
            </g>
        </svg>
    )
}

function ArrowLeft(props: Props) {
    return <ArrowRight className={props.className + ' -scale-x-100'} />
}

export {
    ArrowLeft,
    ArrowRight,
}
