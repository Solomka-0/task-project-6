export type APIResponse<T> = {

    response: {
        data: T,
        execution_time: number
    }
}
