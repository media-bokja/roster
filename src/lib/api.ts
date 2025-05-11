import {Profile} from '@/lib/types.ts'

let baseUrl = ''
let nonce = ''

const initApi = (_baseUrl: string, _nonce: string): void => {
    baseUrl = _baseUrl
    nonce = _nonce
}

type QueryResult<T> = {
    result: T[]
    page: number
    maxPage: number
    total: number
}

namespace Roster {
    export const query = async (query: string = ''): Promise<QueryResult<Profile>> => {
        const endpoint = `${baseUrl}/roster${query.length > 0 ? `?${query}` : ''}`

        const r = await fetch(endpoint, {
            method: 'GET',
            headers: {
                'Origin': location.origin,
                'X-WP-Nonce': nonce,
            },
        })

        return await r.json()
    }
}

export {
    initApi,
    Roster,
}
