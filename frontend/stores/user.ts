import {defineStore} from "pinia"
import AuthUser, {type Response, type Request} from "@/api/endpoints/AuthUscomer"
import {useLoader} from "~/src/components/Loader/composables/useLoader";
// import { APIGetUserResponse, APIUpdateSettingsResponse, APIUserEndpoints, User, UserSession, UserSettings } from "@/types/User"

export const useUserStore = defineStore("user", {
    state: (): {
        user: { name: string, email: string } | null,
        session: { id: string, ip: string, useragent: string } | null,
    } => ({
        user: null,
        session: null,
    }),
    actions: {
        async handle(session_id?: string | null): Promise<boolean> {

            const authCookie = useCookie<string | null>("sid", {
                path: "/",
                maxAge: 60 * 60 * 24 * 7
            })

            session_id = session_id ?? authCookie.value

            if (!session_id) {
                return false
            } else {
                await new AuthUser(ref({sid: session_id})).request((response) => {
                    this.user = response.general
                    this.session = response.session
                    authCookie.value = response.session.id
                    // console.log('authCookie.value', authCookie.value)
                })
            }

            return true
        },

        async auth(data: { email: string, password: string }) {
            const authCookie = useCookie<string | null>("sid", {
                path: "/",
                maxAge: 60 * 60 * 24 * 7
            })

            const loader = useLoader()
            loader.setState(true)
            try {
                await new AuthUser(data).request((response) => {
                    this.user = response.general
                    this.session = response.session
                    authCookie.value = response.session.id
                    return navigateTo('/')
                })
            } catch (e) {
                throw new Error('Ошибка авторизации')
            } finally {
                loader.setState(false)
            }
        },

        async logout() {
            const authCookie = useCookie<string | null>("sid", {
                path: "/",
                maxAge: 60 * 60 * 24 * 7
            })
            authCookie.value = null
            this.user = null
            this.session = null
            return navigateTo('/login')
        }
    },
})