import useMonthlyEventsQuery from '@/components/pages/use-monthly-events-query'
import ItemMonthlyEvents from '@/components/parts/item-monthly-events'
import useRosterContext from '@/lib/context'
import {ActionType} from '@/lib/reducer'
import {useEffect, useState} from 'react'
import {type Profile} from '@/lib/types'

export default function MonthlyOverview() {
    const {
        dispatch,
    } = useRosterContext()

    const [year] = useState(new Date().getFullYear())
    const [month] = useState(new Date().getMonth() + 1)

    const {data, isLoading, isSuccess} = useMonthlyEventsQuery(year, month)

    /* Change layout here */
    useEffect(() => {
        dispatch({
            type: ActionType.SET_LAYOUT,
            payload: {
                showLoading: isLoading,
            },
        })
    }, [isLoading, data])

    if (!isSuccess || !data) {
        return null
    }

    const {
        birthday,
        dateOfDeath,
        nameDay,
    } = data

    return (
        <div className="mt-8">
            <div className="divider" />
            <div className="flex justify-center items-center">
                {/*<ArrowRight className="size-[1.2em] -scale-x-100" />*/}
                <h2 className="text-2xl text-bold mx-2">
                    {year}년 {month}월
                </h2>
                {/*<ArrowRight className="size-[1.2em]" />*/}
            </div>
            <div className="divider" />

            {/* 생일 */}
            <ItemMonthlyEvents
                className={'mt-8'}
                field={'birthday'}
                fieldLabel={'생일'}
                items={birthday}
                label={'생일이신 분'}
                noItemsText={'이 달에는 생일이신 분이 없습니다.'}
            />

            {/* 축일 */}
            <ItemMonthlyEvents
                className={'mt-8'}
                field={'nameDay'}
                fieldLabel={'축일'}
                items={nameDay}
                label={'축일이신 분'}
                noItemsText={'이 달에는 축일이신 분이 없습니다.'}
                valueFunc={(item: Profile) => {
                    const [month, day] = item.nameDay.split('-')
                    return `${month}월 ${day}일`
                }}
            />

            {/* 선종일 */}
            <ItemMonthlyEvents
                className={'mt-8 mb-4'}
                field={'dateOfDeath'}
                fieldLabel={'선종일'}
                items={dateOfDeath}
                label={'선종하신 분'}
                noItemsText={'이 달에는 선종하신 분이 없습니다.'}
            />
        </div>
    )
}
