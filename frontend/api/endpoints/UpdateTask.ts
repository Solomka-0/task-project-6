import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {Task} from "~/types/Common";

export type Request = Task
export type Response = undefined

export default class UpdateTask extends BaseApiRequest<Request, Response> {
    method = ApiMethods.PUT

    public endpoint = '/api/tasks/'
}