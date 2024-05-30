export const useSearchPending = (timeout?: number) => reactive(new searchPending(timeout))

// Реализует задержку между запросами на сервер (по умолчанию 0.4 сек)
class searchPending {
    public static entity: searchPending | null = null
    public timer: NodeJS.Timeout | undefined
    public timeout: number = 400

    constructor(timeout?: number) {
        if (searchPending.entity == null) {
            searchPending.entity = this
        }
        searchPending.entity.timeout = timeout ?? searchPending.entity.timeout
        return searchPending.entity
    }

    public pending(callback: TimerHandler) {
        clearTimeout(this.timer)
        this.timer = setTimeout<any>(callback, this.timeout)
    }
}