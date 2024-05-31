import {defineStore} from "pinia"
import type {User} from "~/types/Common";
import {GetUsers} from "@/api/endpoints/users/GetUsers"
import {GetUser} from "~/api/endpoints/users/GetUser";
export const useUsersStore = defineStore("users", {
    state: (): {
        user?: User,
        users: User[],
        results: User[],
    } => ({
        user: undefined,
        users: [],
        results: []
    }),
    actions: {
        async get(id?: number){
            if (id) {
                this.user = (await new GetUser().request(id)).value
            } else {
                this.users = (await new GetUsers().request()).value
            }
        },
        async usersLike(like: string) {
            this.results = (await new GetUsers({like: like}).request()).value
        }
    },
})