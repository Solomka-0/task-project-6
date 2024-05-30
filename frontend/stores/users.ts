import {defineStore} from "pinia"
import type {User} from "~/types/Common";
import {GetUsers} from "@/api/endpoints/users/GetUsers"
import type {Ref} from "@vue/reactivity";
export const useUsersStore = defineStore("users", {
    state: (): {
        users: User[],
        results: User[],
    } => ({
        users: [],
        results: []
    }),
    actions: {
        async get(){
            this.users = (await new GetUsers().request()).value
        },
        async usersLike(like: string) {
            this.results = (await new GetUsers({like: like}).request()).value
        }
    },
})