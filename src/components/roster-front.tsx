import Archive from '@/components/pages/archive.tsx'
import Dialog from '@/components/pages/dialog.tsx'
import {useState} from 'react'

export default function RosterFront() {
    const [showDialog, setShowDialog] = useState(false)

    return (
        <>
            <Archive onClickItem={() => setShowDialog(true)} />
            {showDialog && <Dialog onClickDialog={() => setShowDialog(false)} />}
        </>
    )
}
