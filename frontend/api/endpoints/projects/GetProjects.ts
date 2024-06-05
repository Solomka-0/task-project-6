import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {Project} from "~/types/Common";

export type Request = {
    like?: string
}
export type Response = Project[]

export class GetProjects extends BaseApiRequest<Request, Response> {
    method = ApiMethods.GET

    public endpoint = '/api/projects/'
}