import {BaseApiRequest} from "~/api/web";
import type {APIResponse} from "~/types/APIResponse";

export type Request = {
    id?: number
    house_id?: number
    telegram_id?: string
    whatsapp_id?: string
}

export type Response = {
    status: string
}

export default class Example extends BaseApiRequest<Request, Response> {
    public endpoint = '/api/example-endpoint/test'
}