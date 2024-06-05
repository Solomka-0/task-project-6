import {defineStore} from "pinia"
import type {Project} from "~/types/Common";
import {GetProject} from "~/api/endpoints/projects/GetProject";
import {GetProjects} from "~/api/endpoints/projects/GetProjects";
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
            if (id) {
                this.project = (await new GetProject().request(id)).value
            } else {
                this.projects = (await new GetProjects().request()).value
            }
        },
        async usersLike(like: string) {
            this.results = (await new GetProjects({like: like}).request()).value
        }
    },
})