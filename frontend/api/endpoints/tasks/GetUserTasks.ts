import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {Task} from "~/types/Common";

export type Request = {
    current?: boolean
}
export type Response = Task[]

export default class GetUserTasks extends BaseApiRequest<Request, Response> {
    method = ApiMethods.GET

    public endpoint = '/api/tasks/users/'
}