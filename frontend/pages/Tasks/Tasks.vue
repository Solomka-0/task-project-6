<template>
  <div class="tasks-page">
    <div class="page-content container">
      <my-tasks/>
    </div>
  </div>
</template>

<script setup="ts">
import {defineI18nRoute} from "#i18n";
import MyTasks from "~/src/modules/MyTasks/MyTasks.vue";

// i18
const i18nPrefix = "pages.Tasks"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

defineI18nRoute({
  paths: {
    'en': '/tasks',
    'de': '/tasks',
    'es': '/tasks',
    'fr': '/tasks',
    'it': '/tasks',
    'pt': '/tasks',
    'zh': '/tasks',
    'ja': '/tasks',
    'ko': '/tasks',
    'ru': '/tasks',
    'hi': '/tasks',
    'pl': '/tasks',
    'cs': '/tasks',
  }
})

</script>

<style>
@import "./style.scss";
</style>