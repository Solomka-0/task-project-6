<template>
  <div class="home-page">
    <div class="page-content container">
      <div class="home-page__greeting-block">
        <img src="/images/homepage.png" class="max-w-[10vw] h-fit">
        <div class="max-w-[500px]">
          Приветствую!
          <br>
          <br>
          Этот проект - решение тестового задания по теме создания
          примитивного таск-менеджера.
          Задание предполагало использование vuex, vue-router, работа с которыми заложена в nuxt
          <br>
          <br>
          Основной функционал <nuxt-link :to="localePath(getPageName('Tasks'))" class="link">здесь</nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup="ts">
import {defineI18nRoute} from "#i18n";
import {useLoader} from "~/src/components/Loader/composables/useLoader";
import {useNotice} from "~/src/components/Notices/composables/useNotice";

const loader = useLoader()
const notices = useNotice()

// i18
const i18nPrefix = "pages.Home"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const localePath = useLocalePath()
const getPageName = nuxtApp.$getPageName


const onError = () => {
  throw new Error('Ошибка')
}

defineI18nRoute({
  paths: {
    'en': '/',
    'de': '/',
    'es': '/',
    'fr': '/',
    'it': '/',
    'pt': '/',
    'zh': '/',
    'ja': '/',
    'ko': '/',
    'ru': '/',
    'hi': '/',
    'pl': '/',
    'cs': '/',
  }
})

</script>

<style>
@import "./style.scss";
</style>