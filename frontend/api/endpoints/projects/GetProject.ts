import {ApiMethods, BaseApiRequest} from "~/api/web";
import type {Project} from "~/types/Common";

export type Request = any
export type Response = Project

export class GetProject extends BaseApiRequest<Request, Response> {
    method = ApiMethods.GET

    public endpoint = '/api/projects/'
}