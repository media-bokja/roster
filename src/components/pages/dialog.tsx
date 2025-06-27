import HighlightSearch from '@/components/parts/highlight-search'
import useRosterContext from '@/lib/context'
import type {Profile} from '@/lib/types'
import nl2br from 'react-nl2br'

type Props = {
    open: boolean
    onClickThumbnail?: () => void
    onClose?: () => void
    profile?: Profile
}

export default function Dialog(props: Props) {
    const {
        open,
        onClickThumbnail,
        onClose,
        profile,
    } = props

    const {
        state: {
            sitemeta: {
                pageTitle,
            },
        },
    } = useRosterContext()

    if (!open || !profile) {
        return null
    }

    const headerClass = 'py-1 w-27 tracking-tight',
        valueClass = 'py-1 break-keep traking-tight md:max-w-36'

    return (
        <dialog className="modal" open={true}>
            <div className="modal-box max-w-fit max-h-11/12">
                <form method="dialog">
                    <button
                        className="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                        onClick={() => onClose && onClose()}
                    >✕
                    </button>
                </form>
                <div>
                    <h2 className="text-xl font-bold">
                        {pageTitle} 상세
                    </h2>
                    <section className="roster-single mt-6">
                        <div className="flex flex-wrap gap-x-1 lg:gap-x-3 gap-y-6">
                            {'thumbnail' in profile.profileImage && (
                                <figure
                                    className="w-full sm:w-24 md:w-42 xl:w-56 cursor-pointer shrink"
                                    onClick={() => onClickThumbnail && onClickThumbnail()}
                                >
                                    <img
                                        alt={`${profile.name} ${profile.baptismalName} 프로필 섬네일 이미지`}
                                        title={`${profile.name} ${profile.baptismalName} 프로필 섬네일 이미지`}
                                        className="w-fullborder border-neutral-200 shadow-lg rounded-lg"
                                        src={profile.profileImage.medium.path}
                                    />
                                </figure>
                            )}
                            <div className="rounded-box border-none bg-base-100 shrink">
                                <table className="table" role="presentation">
                                    <tbody>
                                    <tr>
                                        <th className={headerClass} scope="row">이름</th>
                                        <td className={valueClass}>
                                            <HighlightSearch text={profile.name} />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">국적</th>
                                        <td className={valueClass}>{profile.nationality}</td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">세례명 (축일)</th>
                                        <td className={valueClass}>
                                            <HighlightSearch text={profile.baptismalName} />
                                            {profile.nameDay.length > 0 && ` (${profile.nameDay})`}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">수도명</th>
                                        <td className={valueClass}>
                                            <HighlightSearch text={profile.monasticName} />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">현소임지</th>
                                        <td className={valueClass}>
                                            <HighlightSearch text={profile.currentAssignment} />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">비고</th>
                                        <td className={valueClass}>
                                            {nl2br(profile.remarks)}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div className="rounded-box border-none bg-base-100 shrink">
                                <table className="table" role="presentation">
                                    <tbody>
                                    <tr>
                                        <th className={headerClass} scope="row">생일</th>
                                        <td className={valueClass}>{profile.birthday}</td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">입회일</th>
                                        <td className={valueClass}>{profile.entranceDate}</td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">첫서원일</th>
                                        <td className={valueClass}>{profile.initialProfessionDate}</td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">종신서원일</th>
                                        <td className={valueClass}>{profile.perpetualProfessionDate}</td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">서품일</th>
                                        <td className={valueClass}>{profile.ordinationDate}</td>
                                    </tr>
                                    <tr>
                                        <th className={headerClass} scope="row">선종일</th>
                                        <td className={valueClass}>{profile.dateOfDeath}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
                <div className="modal-action">
                    <form method="dialog">
                        <button
                            className="btn"
                            onClick={() => onClose && onClose()}
                        >
                            닫기
                        </button>
                    </form>
                </div>
            </div>
        </dialog>
    )
}
