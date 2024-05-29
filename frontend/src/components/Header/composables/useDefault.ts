// import {Logout} from '@/api/endpoints/auth/Logout'
import {useUserStore} from "~/stores/user";

export const useDefaultState = () => useState('header', () => (<{
    state: boolean
    nav: { title: string, path: string }[],
}>{
    state: false,
    nav: [
        {
            title: "Главная",
            path: "/"
        },
    ],
    logout: async () => {
        await useUserStore().logout()
    }
}))