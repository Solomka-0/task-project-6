import type {APIResponse} from "~/types/APIResponse";
import type {Ref} from "@vue/reactivity";
import {distDir} from "@nuxt/devtools/dist/dirs";
import {useUserStore} from "~/stores/user";

export enum ApiMethods {
    GET = "GET",
    POST = "POST",
    PUT = "PUT",
    DELETE = "DELETE"
}

export class BaseApiRequest<Request, Response> {
    protected endpoint
    protected method: ApiMethods = ApiMethods.POST
    protected _requestBody?: Request
    protected _response: Ref<Response>

    constructor(requestBody?: Request) {
        this._requestBody = requestBody
    }

    async request(id?: string | number, body?: Request, callback?: (response: Response) => void) {
        try {
            let query
            const options = {
                method: this.method
            }

            if (this.method === ApiMethods.DELETE) {
                options['headers'] = {
                    'Content-Type': 'application/json',
                }
                options['body'] = {}
            }

            if (this.method === ApiMethods.GET) {
                options['headers'] = {
                    'Content-Type': 'application/json',
                }
                query = `?${new URLSearchParams(this._requestBody)}`
            } else if (!!this._requestBody || !!body) {
                options['body'] = this._requestBody ?? body
            }

            if (!!useUserStore().token) {
                options['headers'] = {
                    'Bearer': useUserStore().token,
                }
            }

            const response = await $fetch<APIResponse<Response>>(this.endpoint + (id ? `${id}` : '') + (query ?? ''), options)
                .catch((error) => {
                    switch (error.status) {
                        case 401:
                            useUserStore().logout()
                    }
                })
            this._response = ref(response)

            if (!!callback) {
                callback(this._response?.value)
            }
        } catch (e) {
            throw e
        }
        return this._response
    }

    get response() {
        return this._response
    }

    set requestBody(requestBody: Request) {
        this._requestBody = requestBody
    }
}
