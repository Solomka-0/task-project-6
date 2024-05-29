import {useUserStore} from "~/stores/user";

export default defineNuxtRouteMiddleware(async (to, from) => {
    const userStore = useUserStore()
    const init = await userStore.init()

    if (to.fullPath === '/login' && init) {
        return navigateTo('/')
    }

    if (to.fullPath === '/login' || to.fullPath === '/' || to.fullPath.match(/^\/api\//i)) return

    if (!userStore.user || !userStore.token) {
        return navigateTo('/login')
    }
})