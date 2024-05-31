import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {User} from "~/types/Common";

export type Request = any
export type Response = User

export class GetUser extends BaseApiRequest<Request, Response> {
    method = ApiMethods.GET

    public endpoint = '/api/users/'
}