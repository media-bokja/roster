import useRosterContext from '@/lib/context'
import Highlighter from 'react-highlight-words'

type Props = {
    text: string
}

export default function HighlightSearch(props: Props) {
    const {
        text,
    } = props

    const {
        state: {
            siteParams: {
                search,
            },
        },
    } = useRosterContext()

    if (!search || 0 === search.length) {
        return text
    }

    return (
        <Highlighter
            highlightClassName={"bg-yellow-300 font-bold text-red-800"}
            searchWords={[search]}
            textToHighlight={text}
        />
    )
}