import useRosterContext from '@/lib/context'

export default function Header() {
    const {
        state: {
            sitemeta: {
                homeUrl,
                profileAdminUrl,
                rosterAdminUrl,
                siteIcon,
                siteTitle,
                siteUrl,
                userAvatar,
                userName,
            },
        },
    } = useRosterContext()

    return (
        <header className="">
            <nav className="navbar bg-base-300 shadow-sm py-0 min-h-0">
                <div className="flex-1">
                    <a href={siteUrl} className="btn btn-ghost text-[1rem]">
                        <img src={siteIcon} className="h-6 w-6 me-1" alt={siteTitle}/>
                        <span className="hidden sm:block">{siteTitle}</span>
                    </a>
                </div>
                <div className="flex-none">
                    <ul className="menu menu-horizontal px-1 text-xs items-center">
                        <li>
                            <label className="flex cursor-pointer gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round">
                                    <circle cx="12" cy="12" r="5"/>
                                    <path
                                        d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"/>
                                </svg>
                                <input
                                    className="toggle theme-controller toggle-sm"
                                    type="checkbox"
                                    value="dark"
                                />
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round">
                                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                                </svg>
                            </label>
                        </li>
                        <li>
                            <details>
                                <summary className="min-w-32">
                                    <img src={userAvatar} className="h-4 w-4" alt="사용자 아바타"/>
                                    {userName}
                                </summary>
                                <ul className="bg-base-100 rounded-t-none p-2 z-100">
                                    <li>
                                        <a href={profileAdminUrl}>
                                            관리자 프로필
                                        </a>
                                    </li>
                                    {rosterAdminUrl.length > 0 && (
                                        <li>
                                            <a href={rosterAdminUrl}>
                                                관리자 회원명부
                                            </a>
                                        </li>
                                    )}
                                    <li>
                                        <a href={homeUrl} className="">
                                            홈으로 나가기
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    )
}
