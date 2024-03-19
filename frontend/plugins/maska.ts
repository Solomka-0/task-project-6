import { vMaska } from "maska"
// import {VueReCaptcha} from "vue-recaptcha-v3";

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.directive("maska", vMaska)
  // nuxtApp.vueApp.use(VueReCaptcha, {
  //   "siteKey": "6LcGNBEpAAAAAAvPTPkaiglR4bv04z6Q7LU8U9lP"
  // })
})