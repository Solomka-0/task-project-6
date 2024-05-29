import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {Task} from "~/types/Common";

export type Request = Task
export type Response = Task

export default class StoreTask extends BaseApiRequest<Request, Response> {
    method = ApiMethods.POST

    public endpoint = '/api/tasks/'
}