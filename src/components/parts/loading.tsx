type Props = {
    show?: boolean
    message?: string
}

export default function Loading(props: Props) {
    const {
        show,
        message,
    } = props

    if (!show) {
        return null
    }

    return (
        <div className="loading-cotainer text-center self-center" role="alert">
            <p>
                <span className="loading loading-spinner loading-xl" />
            </p>
            <p className="mt-4 font-bold">
                {!!message || '불러오는 중입니다. 잠시만 기다려 주십시오.'}
            </p>
        </div>
    )
}