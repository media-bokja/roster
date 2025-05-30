import {MonthlyEvents} from '@/lib/api'
import {useQuery} from '@tanstack/react-query'

export default function useMonthlyEventsQuery(month: number) {
    return useQuery({
        queryKey: ['monthlyEvents', 'get', [month]],
        queryFn: () => {
            return MonthlyEvents.get(month)
        },
    })
}
