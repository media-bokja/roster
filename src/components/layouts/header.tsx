import useRosterContext from '@/lib/context'

export default function Header() {
    const {
        sitemeta: {
            avatarUrl,
            homeUrl,
            siteIcon,
            siteTitle,
            siteUrl,
            userAvatar,
            userName,
        },
    } = useRosterContext()

    return (
        <header className="">
            <nav className="navbar bg-base-300 shadow-sm py-0 min-h-0">
                <div className="flex-1">
                    <a href={siteUrl} className="btn btn-ghost text-[1rem]">
                        <img src={siteIcon} className="h-6 w-6 me-1" alt={siteTitle} />
                        <span className="hidden sm:block">{siteTitle}</span>
                    </a>
                </div>
                <div className="flex-none">
                    <ul className="menu menu-horizontal px-1 text-xs items-center">
                        <li>
                            <a href={homeUrl} className="">
                                홈으로 이동
                            </a>
                        </li>
                        <li>
                            <a className="" href={avatarUrl}>
                                <img src={userAvatar} className="h-4 w-4" alt="사용자 아바타" />
                                {userName}
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    )
}
