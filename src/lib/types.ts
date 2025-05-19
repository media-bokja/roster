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
}

type SiteParams = {
    p: number      // Profile ID.
    page: number   // Page number
    search: string // Search keyword
    orderby: string
    order: string
}

type RosterLayout = {
    condensed: boolean
    showLoading: boolean
    verticalCenter: boolean
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

export type {
    Action,
    Profile,
    ProfileImage,
    RosterLayout,
    RosterState,
    SiteMeta,
    SiteParams,
}
