export default defineNuxtRouteMiddleware(async (to, from) => {
    // if (to.meta.auth === false) return
    //
    // const sessionCookie = useCookie("sid", {
    //     path  : "/",
    //     maxAge: 60 * 60 * 24 * 14
    // })
    //
    // const userStore = useUserStore()
    //
    // if (userStore.user && userStore.session) {
    //     return
    // }
    //
    // if (!userStore.user && !userStore.session && !sessionCookie.value) {
    //     if (!await userStore.handle(sessionCookie.value)) {
    //         return navigateTo('/login')
    //     }
    // }
})