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
        },
        chart: {
            month: {
                 [key: string]: number,
            },
            week: {
                [key: string]: number,
            },
            day: {
                [key: string]: number,
            },
        }
    }
}

export type Task = {
    id?: number,
    name: string,
    description: string,
    status?: string,
    priority: number,
    user_id: number,
    created_at?: string,
    updated_at?: string,
    user: User
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
    tasks: Task[]
    analytics?: {
        tasks: {
            count: number
        },
        projects: {
            count: number,
            items: {
                [key: number]: {
                    chart: {
                        month: {
                            [key: string]: number,
                        }
                        week: {
                            [key: string]: number,
                        }
                        day: {
                            [key: string]: number,
                        }
                    }
                }
            }
        },
        full: {
            time: {
                full: number,
                last_month: number,
                last_day: number,
                last_week: number,
            },
            chart: {
                month: {
                    [key: string]: number,
                },
                week: {
                    [key: string]: number,
                },
                day: {
                    [key: string]: number,
                },
            }

        }
    }
}

export type Palette = {
    [key: string]: string,
}