import type {Action} from '@/lib/types'

let url: string
let actions: { [key: string]: Action }

function initAjax(_url: string, _actions: { [key: string]: Action }) {
    url = _url
    actions = _actions
}

namespace Ajax {
    export const setTheme = async (theme: string) => {
        if (!('setTheme' in actions)) {
            throw new Error('setTheme not defined.')
        }

        const formData = new FormData()
        formData.append('action', actions.setTheme.action)
        formData.append('nonce', actions.setTheme.nonce)
        formData.append('theme', theme)

        const r = await fetch(url, {
            method: 'POST',
            headers: {
                'Origin': location.origin,
                'X-WP-Nonce': actions.setTheme.nonce,
            },
            body: formData,
        })

        return await r.json()
    }
}

export {
    initAjax,
    Ajax,
}
