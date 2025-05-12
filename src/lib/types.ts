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
    avatarUrl: string
    homeUrl: string
    pageTitle: string
    siteIcon: string
    siteTitle: string
    siteUrl: string
    userAvatar: string
    userName: string
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
    Profile,
    ProfileImage,
    SiteMeta,
}
