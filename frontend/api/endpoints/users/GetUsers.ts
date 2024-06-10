import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {User} from "~/types/Common";

export type Request = {
    analytics: boolean
    like?: string
}
export type Response = User[]

export class GetUsers extends BaseApiRequest<Request, Response> {
    method = ApiMethods.GET

    public endpoint = '/api/users/'
}