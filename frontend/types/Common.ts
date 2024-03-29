export type Task = {
    id?: number,
    name: string,
    description: string,
    status?: string,
    created_at?: string,
    updated_at?: string,
}

export type Palette = {
    [key: string]: string,
}

export const taskStatusesPalette: Palette = {
    'not started': '#ff4d4d',
    'in process': '#66a3e1',
    'complete': '#75d267',
}