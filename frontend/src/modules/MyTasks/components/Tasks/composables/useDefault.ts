export const useDefaultState = () => useState('tasks', () => ({
    isOpen: false,
    form: {
        edit: {
            name: false,
            description: false,
            status: false,
        }
    },
}))