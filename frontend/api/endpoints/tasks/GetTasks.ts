import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {Task} from "~/types/Common";

export type Request = {
    startFrom?: string
    status?: string
}
export type Response = Task[]

export default class GetTasks extends BaseApiRequest<Request, Response> {
    method = ApiMethods.GET

    public endpoint = '/api/tasks'
}