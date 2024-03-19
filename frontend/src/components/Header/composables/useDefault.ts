export const useDefaultState = () => useState('header', () => (<{
    state: boolean
    nav: { title: string, path: string }[],
}>{
    state: false,
    nav: [
        {
            title: "Главная",
            path: "/"
        },
    ]
}))