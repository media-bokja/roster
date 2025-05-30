import {ArrowLeft, ArrowRight} from '@/components/icons/arrow'
import Dialog from '@/components/pages/dialog'
import useMonthlyEventsQuery from '@/components/pages/use-monthly-events-query'
import {ImageFull} from '@/components/parts/image-full'
import ItemMonthlyEvents from '@/components/parts/item-monthly-events'
import useRosterContext from '@/lib/context'
import {ActionType} from '@/lib/reducer'
import {type Profile} from '@/lib/types'
import {useCallback, useEffect, useState} from 'react'

const theMonth = new Date().getMonth() + 1

export default function MonthlyOverview() {
    const {
        dispatch,
    } = useRosterContext()

    const [month, setMonth] = useState(theMonth)
    const [currentProfile, setCurrentProfile] = useState<Profile | undefined>(undefined)
    const [showPopup, setShowPopup] = useState<boolean>(false)

    const setNextMonth = useCallback(() => {
        if (12 === month) {
            setMonth(1)
        } else {
            setMonth(month + 1)
        }
    }, [month])

    const setPrevMonth = useCallback(() => {
        if (1 === month) {
            setMonth(12)
        } else {
            setMonth(month - 1)
        }
    }, [month])

    const {data, isLoading, isSuccess} = useMonthlyEventsQuery(month)

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
        <>
            <div className="mt-8">
                <div className="divider" />
                <div className="flex justify-center items-center">
                    <span
                        onClick={() => setPrevMonth()}
                    ><ArrowLeft className="size-[1.2em] hover:cursor-pointer" /></span>
                    <h2 className="text-2xl text-bold mx-2">
                        {month}월
                    </h2>
                    <span
                        onClick={() => setNextMonth()}
                    ><ArrowRight className="size-[1.2em] hover:cursor-pointer" /></span>
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
                    onClickItem={(item: Profile) => {
                        setCurrentProfile(item)
                    }}
                />

                {/* 축일 */}
                <ItemMonthlyEvents
                    className={'mt-8'}
                    field={'nameDay'}
                    fieldLabel={'축일'}
                    items={nameDay}
                    label={'축일이신 분'}
                    noItemsText={'이 달에는 축일이신 분이 없습니다.'}
                    onClickItem={(item: Profile) => {
                        setCurrentProfile(item)
                    }}
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
                    onClickItem={(item: Profile) => {
                        setCurrentProfile(item)
                    }}
                />
            </div>
            <Dialog
                open={!!currentProfile}
                onClickThumbnail={() => setShowPopup(true)}
                onClose={() => {
                    setCurrentProfile(undefined)
                }}
                profile={currentProfile}
            />
            <ImageFull
                open={showPopup}
                onClose={() => setShowPopup(false)}
                profile={currentProfile}
            />
        </>
    )
}
