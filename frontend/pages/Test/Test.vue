<template>
  <div class="test-page">
    <div class="page-content container">
      <fridge v-model:state="fridgeState">
        [Контент]
      </fridge>
      <div class="btn btn_primary" @click="fridgeState = !fridgeState">
        btn
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {defineI18nRoute} from "#i18n";
import Fridge from "~/src/components/Fridge/Fridge.vue";

// i18
const i18nPrefix = "pages.Test"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const fridgeState = ref(true)

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