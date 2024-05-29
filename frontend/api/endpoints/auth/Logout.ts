import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {APIResponse} from "~/types/APIResponse";

export type Request = {}

export type Response = any

export default class Logout extends BaseApiRequest<Request, Response> {
    public method = ApiMethods.POST
    public endpoint = '/api/auth/logout'
}