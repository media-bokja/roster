import type {Profile} from '@/lib/types'

type Props = {
    open: boolean
    onClose?: () => void
    profile?: Profile
}

export default function Dialog(props: Props) {
    const {
        open,
        onClose,
        profile,
    } = props

    if (!open || !profile) {
        return null
    }

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
                    <h2 className="text-xl font-bold">명단 상세</h2>
                    <section className="roster-single mt-6">
                        <div className="flex flex-wrap gap-x-2 lx:gap-x-8 gap-y-6">
                            {'thumbnail' in profile.profileImage && (
                                <figure className="w-full sm:w-48 md:w-56 xl:w-64">
                                    <img
                                        alt={`${profile.name} ${profile.baptismalName} 포로필 섬네일 이미지`}
                                        title={`${profile.name} ${profile.baptismalName} 포로필 섬네일 이미지`}
                                        className="w-fullborder border-neutral-200 shadow-lg rounded-lg"
                                        src={profile.profileImage.full.path}
                                    />
                                </figure>
                            )}
                            <div className="overflow-x-auto rounded-box border-none bg-base-100">
                                <table className="table" role="presentation">
                                    <tbody>
                                    <tr>
                                        <th className="py-1" scope="row">이름</th>
                                        <td className="py-1">{profile.name}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1" scope="row">세례명</th>
                                        <td className="py-1">{profile.baptismalName}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1" scope="row">수도명</th>
                                        <td className="py-1">{profile.monasticName}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1" scope="row">현소임지</th>
                                        <td className="py-1">{profile.currentAssignment}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1 align-top" scope="row">전 소임지</th>
                                        <td className="py-1">
                                            <ul className="leading-6">
                                                {profile.formerAssignments.length > 0 && (
                                                    profile.formerAssignments
                                                        .split('\r\n')
                                                        .map((assignment) => assignment.trim())
                                                        .filter((assignment) => assignment.length > 0)
                                                        .map((assignment, i) => (
                                                            <li key={i} className="flex items-center">
                                                                <div aria-label="status"
                                                                     className="status me-1 status-info" />
                                                                {assignment}
                                                            </li>
                                                        ))
                                                )}
                                            </ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div className="overflow-x-auto rounded-box border-none bg-base-100">
                                <table className="table" role="presentation">
                                    <tbody>
                                    <tr>
                                        <th className="py-1" scope="row">생일</th>
                                        <td className="py-1">{profile.birthday}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1" scope="row">입회일</th>
                                        <td className="py-1">{profile.entranceDate}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1" scope="row">첫 서원일</th>
                                        <td className="py-1">{profile.initialProfessionDate}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1" scope="row">종신서원일</th>
                                        <td className="py-1">{profile.perpetualProfessionDate}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1" scope="row">서품일</th>
                                        <td className="py-1">{profile.ordinationDate}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1" scope="row">퇴회일</th>
                                        <td className="py-1">{profile.departureDate}</td>
                                    </tr>
                                    <tr>
                                        <th className="py-1" scope="row">사망일</th>
                                        <td className="py-1">{profile.dateOfDeath}</td>
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
