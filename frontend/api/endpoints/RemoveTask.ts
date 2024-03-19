import {ApiMethods, BaseApiRequest} from "~/api/web";

export type Response = undefined

export default class RemoveTask extends BaseApiRequest<Request, Response> {
    method = ApiMethods.DELETE

    public endpoint = '/api/tasks/'
}