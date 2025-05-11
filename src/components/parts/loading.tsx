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
        <div className="w-lvw h-lvh bg-base-300/80 fixed z-9999 flex justify-center items-center">
            <div className="w-full text-center">
                <p>
                    <span className="loading loading-spinner loading-xl" />
                </p>
                <p className="mt-4 font-bold">
                    {!!message || '불러오는 중입니다. 잠시만 기다려 주십시오.'}
                </p>
            </div>
        </div>
    )
}