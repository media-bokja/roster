type Props = {
    onClickDialog: () => void
}

export default function Dialog(props: Props) {
    return (
        <dialog className="modal" open={true}>
            <div className="modal-box w-11/12 max-w-5xl max-h-11/12">
                <form method="dialog">
                    <button
                        className="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                        onClick={() => props.onClickDialog()}
                    >
                        ✕
                    </button>
                </form>
                <div>
                    <h2 className="text-xl font-bold">명단 상세</h2>
                    <section className="roster-single mt-6">
                        <div className="flex flex-wrap gap-x-8 gap-y-6">
                            <figure className="">
                                <img
                                    alt="데모 이미지"
                                    className="border border-neutral-200 shadow-lg rounded-lg"
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/Pope_Francis_Korea_Haemi_Castle_19_%284x5_cropped%29.jpg/250px-Pope_Francis_Korea_Haemi_Castle_19_%284x5_cropped%29.jpg"
                                />
                            </figure>
                            <div className="overflow-x-auto rounded-box border-none bg-base-100">
                                <table className="table" role="presentation">
                                    <tbody>
                                    <tr>
                                        <th scope="row">이름</th>
                                        <td>목업 이름</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            세례명
                                        </th>
                                        <td>
                                            목업 세례명
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            수도명
                                        </th>
                                        <td>
                                            목업 수도명
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            현소임지
                                        </th>
                                        <td>
                                            목업 현소임지
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" className="align-top">
                                            전 소임지
                                        </th>
                                        <td>
                                            <ul className="leading-6">
                                                <li className="flex items-center">
                                                    <div aria-label="status" className="status me-1 status-info" />
                                                    전 소임지 #1
                                                </li>
                                                <li>
                                                    <div aria-label="status" className="status me-1 status-info" />
                                                    전 소임지 #2
                                                </li>
                                                <li>
                                                    <div aria-label="status" className="status me-1 status-info" />
                                                    전 소임지 #3
                                                </li>
                                                <li>
                                                    <div aria-label="status" className="status me-1 status-info" />
                                                    전 소임지 #4
                                                </li>
                                                <li>
                                                    <div aria-label="status" className="status me-1 status-info" />
                                                    전 소임지 #5
                                                </li>
                                                <li>
                                                    <div aria-label="status" className="status me-1 status-info" />
                                                    전 소임지 #6
                                                </li>
                                                <li>
                                                    <div aria-label="status" className="status me-1 status-info" />
                                                    전 소임지 #7
                                                </li>
                                                <li>
                                                    <div aria-label="status" className="status me-1 status-info" />
                                                    전 소임지 #8
                                                </li>
                                                <li>
                                                    <div aria-label="status" className="status me-1 status-info" />
                                                    전 소임지 #9
                                                </li>
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
                                        <th scope="row">생일</th>
                                        <td>0000년 00월 00일</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">입회일</th>
                                        <td>0000년 00월 00일</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">첫 서원일</th>
                                        <td>0000년 00월 00일</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">종신서원일</th>
                                        <td>0000년 00월 00일</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">서품일</th>
                                        <td>0000년 00월 00일</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">퇴회일</th>
                                        <td>0000년 00월 00일</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">사망일</th>
                                        <td>0000년 00월 00일</td>
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
                            onClick={() => props.onClickDialog()}
                        >
                            닫기
                        </button>
                    </form>
                </div>
            </div>
        </dialog>
    )
}
