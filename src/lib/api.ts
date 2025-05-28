import {type MonthlyEventsGetResult, Profile} from '@/lib/types.ts'

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
    type Query = {
        orderby?: string
        order?: string
        page?: number
        perpage?: number
        search?: string
    }

    export const query = async (query: Query = {}): Promise<QueryResult<Profile>> => {
        const q = new URLSearchParams()

        query.order && q.set('order', query.order)
        query.orderby && q.set('orderby', query.orderby)
        query.page && q.set('page', query.page.toString())
        query.perpage && q.set('perpage', query.perpage.toString())
        query.search && q.set('search', query.search)

        const qs = q.toString()

        const endpoint = `${baseUrl}/roster${qs.length > 0 ? `?${qs}` : ''}`

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

namespace MonthlyEvents {
    export const get = async (year: number, month: number): Promise<MonthlyEventsGetResult> => {
        const endpoint = `${baseUrl}/monthly-events/${year}/${month}`

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
    MonthlyEvents,
    Roster,
}
