export const priority: {
    [key: number]: {
        name: string,
        color: string
    }
} = {
    0: {
        name: 'Обычный',
        color: 'rgb(156 163 175)',
    },
    1: {
        name: 'Низкий',
        color: '#346ccc',
    },
    2: {
        name: 'Средний',
        color: '#d6b224',
    },
    3: {
        name: 'Высокий',
        color: '#cc2e2e',
    },
}
export const status: {
    [key: string]: {
        name: string,
        color: string
    }
} = {
    'not started': {
        name: 'Не начата',
        color: 'rgb(156 163 175)',
    },
    'in process': {
        name: 'В процессе',
        color: '#3a67b5',
    },
    'complete': {
        name: 'Завершена',
        color: '#2b9f2c',
    },
}