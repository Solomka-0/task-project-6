export type Project = {
    id: number,
    name: string,
    description: string,
    created_at: string,
    updated_at: string,
    tasks: Task[],
    users: User[],
    analytics?: {
        time: {
            full: number,
            last_month: number,
            last_day: number,
            last_week: number,
        }
    }
}

export type Task = {
    id?: number,
    name: string,
    description: string,
    status?: string,
    created_at?: string,
    updated_at?: string,
}

export enum Rule {
    'admin' = 'Администратор',
    'manager' = 'Руководитель',
    'worker' = 'Исполнитель'
}

export type User = {
    id: number,
    name: string,
    email: string,
    email_verified_at?: string,
    rules: Rule[],
    created_at: string,
    projects: Project[]
}

export type Palette = {
    [key: string]: string,
}