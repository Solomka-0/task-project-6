const runtimeConfig = useRuntimeConfig

const getPageName = (hierarchy: string) => {
    const parts = hierarchy.split("/");
    return `${parts.join("-")}-${parts.slice(-1)}`
}


const i = (prefix) => {
    return (key: string) => {
        const fullKey = `${prefix}.${key}`
        const value = useI18n().t(fullKey)
        return value !== fullKey ? value : `[ ${key} ]`
    }
}

export default defineNuxtPlugin(() => {
    return {
        provide: {
            getPageName: getPageName,
            i: i

        }
    }
})