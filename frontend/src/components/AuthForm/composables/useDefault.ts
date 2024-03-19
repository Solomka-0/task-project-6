import {useUserStore} from "~/stores/user";

export const useDefaultState = () => useState('auth-form', () => (<{
    email?: string,
    password?: string,
}>{

}))