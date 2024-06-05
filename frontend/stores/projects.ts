import {defineStore} from "pinia"
import type {Project} from "~/types/Common";
import {GetProject} from "~/api/endpoints/projects/GetProject";
import {GetProjects} from "~/api/endpoints/projects/GetProjects";
import {useUserStore} from "~/stores/user";
import {Rule} from "~/types/Common";
export const useProjectsStore = defineStore("projects", {
    state: (): {
        project?: Project,
        projects: Project[],
        results: Project[],
    } => ({
        project: undefined,
        projects: [],
        results: []
    }),
    actions: {
        async get(id?: number){
            const params = {
                analytics: useUserStore().user?.rules.filter(rule => ['admin', 'worker'].includes(rule)).length
                    ? true : undefined
            }
            if (id) {
                this.project = (await new GetProject(params).request(id)).value
            } else {
                this.projects = (await new GetProjects(params).request()).value
            }
        },
        async usersLike(like: string) {
            this.results = (await new GetProjects({like: like}).request()).value
        }
    },
})