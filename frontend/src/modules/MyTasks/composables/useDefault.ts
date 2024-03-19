export const useDefaultState = () => useState('my-tasks', () => ({
    filters: <{ status?: string, startFrom?: string }>{
        status: undefined,
        startFrom: undefined,
    }
}))