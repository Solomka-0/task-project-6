import {defineStore} from "pinia"
import type {Task} from "~/types/Common";

export const useTasksStore = defineStore("tasks", {
    state: (): {
        _lastSelectedTask: Task | undefined
    } => ({
        _lastSelectedTask: undefined,
    }),
    actions: {
        selectTask(task: Task) {
            this._lastSelectedTask = task
        },
        clearSelected() {
            this._lastSelectedTask = undefined
        },
    },
    getters: {
        lastSelectedTask: (state) => state._lastSelectedTask,
    }
})