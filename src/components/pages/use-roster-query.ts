import {Roster} from '@/lib/api'
import useRosterContext from '@/lib/context'
import {useQuery} from '@tanstack/react-query'

export default function useRosterQuery() {
    const {
        state: {
            siteParams: {
                page,
                perpage,
                search,
                orderby,
                order,
            },
        },
    } = useRosterContext()

    return useQuery({
        queryKey: ['roster', 'get', [order, orderby, page, perpage, search]],
        queryFn: () => {
            return Roster.query({order, orderby, page, perpage, search})
        },
    })
}
