import {Roster} from '@/lib/api'
import useRosterContext from '@/lib/context'
import {useQuery} from '@tanstack/react-query'

export default function useRosterQuery() {
    const {
        state: {
            siteParams: {
                page,
                search,
            },
        },
    } = useRosterContext()

    return useQuery({
        queryKey: ['roster', 'get', [page, search]],
        queryFn: () => {
            return Roster.query({page, search})
        },
    })
}
