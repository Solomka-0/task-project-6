<template>
  <div class="test-page">
    <div class="page-content container">
      {{ selectedUser }}
      <user-search v-model="selectedUser"/>
    </div>
  </div>
</template>

<script setup lang="ts">
import {defineI18nRoute} from "#i18n";
import type {User} from "~/types/Common";
import UserSearch from "~/src/components/UserSearch/UserSearch.vue";

// i18
const i18nPrefix = "pages.Test"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const selectedUser = ref<User | undefined>()

defineI18nRoute({
  paths: {
    'en': '/test',
    'de': '/test',
    'es': '/test',
    'fr': '/test',
    'it': '/test',
    'pt': '/test',
    'zh': '/test',
    'ja': '/test',
    'ko': '/test',
    'ru': '/test',
    'hi': '/test',
    'pl': '/test',
    'cs': '/test',
  }
})

</script>

<style>
@import "./style.scss";
</style>