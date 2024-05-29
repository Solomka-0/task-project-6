<template>
  <div class="login-page">
    <div class="page-content container">
      <login-form/>
    </div>
  </div>
</template>

<script setup="ts">
import {defineI18nRoute} from "#i18n";
import LoginForm from "~/src/modules/LoginForm/LoginForm.vue";

// i18
const i18nPrefix = "pages.Login"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

defineI18nRoute({
  paths: {
    'en': '/login',
    'de': '/login',
    'es': '/login',
    'fr': '/login',
    'it': '/login',
    'pt': '/login',
    'zh': '/login',
    'ja': '/login',
    'ko': '/login',
    'ru': '/login',
    'hi': '/login',
    'pl': '/login',
    'cs': '/login',
  },
}, )

definePageMeta({
  layout: 'simple'
})

</script>

<style>
@import "./style.scss";
</style>