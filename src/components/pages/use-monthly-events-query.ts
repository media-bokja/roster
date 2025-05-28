import {MonthlyEvents} from '@/lib/api'
import {useQuery} from '@tanstack/react-query'

export default function useMonthlyEventsQuery(year: number, month: number) {
    return useQuery({
        queryKey: ['monthlyEvents', 'get', [year, month]],
        queryFn: () => {
            return MonthlyEvents.get(year, month)
        },
    })
}
