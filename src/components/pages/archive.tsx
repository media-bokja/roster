import PageTitle from '@/components/layouts/page-title.tsx'
import {cn} from '@/lib/utils.ts'

type Props = {
    onClickItem: () => void
}

export default function Archive(props: Props) {
    return (
        <>
            <PageTitle />
            <section className="flex justify-end items-center">
                <div className="text-sm">
                    X페이지, 총 N항목
                </div>
                <div className="w-52 ms-4">
                    <label className={cn(
                        'input',
                        'focus:outline-0 focus:outline-base-300 focus:outline-offset-0',
                        'focus-within:outline-0 focus-within:outline-base-300 focus-within:outline-offset-0',
                    )}>
                        명부 검색
                        <input className="grow" type="search" placeholder="검색어, 이름, ..." />
                    </label>
                </div>
                <button className="ms-2 btn btn-neutral" type="button">검색</button>
            </section>
            <section className={cn(
                'mt-6',
                'grid auto-rows-auto gap-x-4 gap-y-6',
                'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5',
            )}>
                {/* Card:BEG */}
                {Array(25).fill(0).map((_, i) => (
                    <div className="card card-border bg-base-100" key={i}>
                        <a
                            href={'#'}
                            onClick={(e) => {
                                e.preventDefault()
                                props.onClickItem()
                            }}
                        >
                            <figure className="relative">
                                <img
                                    alt="데모 이미지"
                                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                                    width="256"
                                    height="256"
                                />
                                <div className={cn(
                                    'badge badge-secondary',
                                    'text-[0.7rem] px-2 py-0',
                                    'absolute top-1.5 right-1.5',
                                )}>
                                    신규
                                </div>
                            </figure>
                        </a>
                        <div className="card-body px-2 py-4">
                            <a
                                href={'#'}
                                onClick={(e) => {
                                    e.preventDefault()
                                    props.onClickItem()
                                }}
                            >
                                <h2 className="card-title text-base">
                                    존 테일러-긴-이름-예시 야고보-긴-세례명
                                </h2>
                            </a>
                            <p>
                                19XX년 MM월 DD일생, 현 소임지
                            </p>
                        </div>
                    </div>
                ))}
                {/* Card:END */}
            </section>
            <section className="mt-2 flex justify-center">
                <div className="join">
                    <button className="join-item btn">«</button>
                    <button className="join-item btn">1</button>
                    <button className="join-item btn btn-active">2</button>
                    <button className="join-item btn btn-disabled">...</button>
                    <button className="join-item btn">3</button>
                    <button className="join-item btn">4</button>
                    <button className="join-item btn">»</button>
                </div>
            </section>
        </>
    )
}