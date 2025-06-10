type Action = {
    action: string
    nonce: string
}

type Profile = {
    id: number
    name: string
    baptismalName: string
    birthday: string
    currentAssignment: string
    dateOfDeath: string
    entranceDate: string
    initialProfessionDate: string
    monasticName: string
    nameDay: string
    nationality: string
    ordinationDate: string
    perpetualProfessionDate: string
    profileImage: {
        [key: string]: ProfileImage
    }
    remarks: string
    /* API result only */
    isNew: boolean;
}

type SiteMeta = {
    homeUrl: string
    pageTitle: string
    placeholderImage: string
    profileAdminUrl: string
    rosterAdminUrl: string
    siteIcon: string
    siteTitle: string
    siteUrl: string
    theme: string
    userAvatar: string
    userName: string
    version: string
}

type SiteParams = {
    menu: 'roster' | 'monthly-overview'
    p: number       // Profile ID
    page: number    // Page number
    perpage: number // Items per page
    search: string  // Search keyword
    orderby: string
    order: string
}

type RosterLayout = {
    showLoading: boolean
}

type RosterState = {
    layout: RosterLayout
    sitemeta: SiteMeta
    siteParams: SiteParams
}

type ProfileImage = {
    file: string
    filesize: number
    height: number
    'mime-type': string
    path: string
    width: number
}

type MonthlyEventsGetResult = {
    birthday: Profile[]
    dateOfDeath: Profile[]
    nameDay: Profile[]
}

export type {
    Action,
    MonthlyEventsGetResult,
    Profile,
    ProfileImage,
    RosterLayout,
    RosterState,
    SiteMeta,
    SiteParams,
}
