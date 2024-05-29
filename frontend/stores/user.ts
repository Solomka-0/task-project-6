import {defineStore} from "pinia"
import Login, {type Response, type Request} from "@/api/endpoints/auth/Login"
import {useLoader} from "~/src/components/Loader/composables/useLoader";
import type {CookieRef} from "#app";
import Logout from "~/api/endpoints/auth/Logout";
import {reloadNuxtApp} from "#app";
import type {User} from "~/types/Common";
// import { APIGetUserResponse, APIUpdateSettingsResponse, APIUserEndpoints, User, UserSession, UserSettings } from "@/types/User"

export const useUserStore = defineStore("user", {
    state: (): {
        cookie: {
            token: CookieRef<any>
            user: CookieRef<any>
        },
        user: User | null,
        token: string | null,
    } => ({
        cookie: {
            token: useCookie<string | null>("auth_token", {
                path: "/",
                maxAge: 60 * 60 * 24 * 7
            }),
            user: useCookie<object | null>("user", {
                path: "/",
                maxAge: 60 * 60 * 24 * 7
            })
        },
        user: null,
        token: null,
    }),
    actions: {
        async init(session_id?: string | null): Promise<boolean> {
            this.token = this.cookie.token
            this.user = this.cookie.user

            return !!this.token && !!this.user;
        },

        async auth(data: { email: string, password: string }) {
            const loader = useLoader()
            loader.setState(true)
            try {
                const response = (await new Login(data).request())?.value
                this.cookie.token = response.token
                this.cookie.user = response.user
                this.init()
                // reloadNuxtApp()
            } catch (e) {
                this.cookie.token = undefined
                this.cookie.user = undefined
                throw new Error('Ошибка авторизации: ' + e)
            } finally {
                loader.setState(false)
            }
            return navigateTo('/')
        },

        async logout() {
            this.user = null
            this.token = null

            this.cookie.user = undefined
            this.cookie.token = undefined

            try {
                await new Logout().request()
            } catch (e) {
                throw new Error('Ошибка при выходе: ' + e)
            }

            return navigateTo('/login')
        }
    },
})