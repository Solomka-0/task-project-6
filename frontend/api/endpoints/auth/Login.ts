import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {APIResponse} from "~/types/APIResponse";

export type Request = {
    email: string,
    password: string,
}

export type Response = any

export default class Login extends BaseApiRequest<Request, Response> {
    public method = ApiMethods.POST
    public endpoint = '/api/auth/login'
}