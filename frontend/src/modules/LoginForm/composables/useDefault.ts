import Login from '@/api/endpoints/auth/Login'
import {useUserStore} from "~/stores/user";

export const useDefaultState = () => useState('login-form', () => ({
    form: {
        email: '',
        password: '',
    },
    submit: async () => {
        // Валидация полей
        const emailRegexp = /^.*@.*\..*$/i
        const passwordRegexp = /[A-Za-z./\\\]\[0-9!@#$%^&*()_\-]/i
        if (state.value.form.email.match(emailRegexp)
            && state.value.form.password.match(passwordRegexp)) {
            useUserStore().auth(state.value.form)
        } else {
            console.log('Валидация не пройдена')
        }
        return 'nice'
    }
}))

const state = useDefaultState()