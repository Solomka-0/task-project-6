import {defineStore} from "pinia"
import type {Task} from "~/types/Common";
import Tasks from "~/pages/Tasks/Tasks.vue";

export const useTasksStore = defineStore("tasks", {
    state: (): {
        _lastSelectedTask: Task | undefined
        _filters: { status?: string, startFrom?: string }
    } => ({
        _lastSelectedTask: undefined,
        _filters: {
            status: undefined,
            startFrom: undefined,
        }
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