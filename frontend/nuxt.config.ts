// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  vite: {
    vue: {
      script: {
        defineModel: true,
        propsDestructure: true
      }
    }
  },
  devtools: { enabled: true },
  ssr: false,
  modules: ["@pinia/nuxt", "@nuxtjs/i18n", "nuxt-svgo"],

  app: {
    head: {
      meta: [
        {name: "robots", content: "noindex"}
      ],
      script: [
        {
          src: "https://www.google.com/recaptcha/api.js?render=explicit",
          // defer: true,
          async: true
        }
      ]
    }
  },

  runtimeConfig: {
    public: {

    },
  },

  i18n: {
    vueI18n: "i18n.config.ts",
    baseUrl: "https://base.url",
    defaultLocale: "ru",
    strategy: "prefix_and_default",
    lazy: false,
    compilation: {
      escapeHtml: false,
      strictMessage: false,
    },
    detectBrowserLanguage: {
      alwaysRedirect: false,
      fallbackLocale: "",
      redirectOn: "root",
      useCookie: true,
      cookieCrossOrigin: false,
      cookieDomain: null,
      cookieKey: "i18n_redirected",
      cookieSecure: false,
    },
    // Locales
    langDir: "locales",
    locales: [
      {code: "ru", iso: "ru-RU", file: "ru.json"}
    ]
  },

  css: ["@/assets/scss/main.scss"],
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },

  routeRules: {
    "/api/**": {
      proxy: {to: "http://127.0.0.1:8000/api/**"} // Local
    },
  }
})