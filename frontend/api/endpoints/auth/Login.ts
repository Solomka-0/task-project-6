import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {APIResponse} from "~/types/APIResponse";
import type {User} from "~/types/Common";

export type Request = {
    email: string,
    password: string,
}

export type Response = {
    expires_at: string,
    token: string,
    token_type: string,
    user: User
}

export default class Login extends BaseApiRequest<Request, Response> {
    public method = ApiMethods.POST
    public endpoint = '/api/auth/login'
}