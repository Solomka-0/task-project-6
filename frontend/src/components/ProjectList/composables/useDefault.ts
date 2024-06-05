export const useDefaultState = () => useState('project-list', () => ({
    tasksState: [],
    usersState: [],
}))