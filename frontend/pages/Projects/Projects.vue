<template>
  <div class="projects-page">
    <div class="page-content container">
      <project-list v-model="projects"/>
    </div>
  </div>
</template>

<script setup="ts">
import {defineI18nRoute} from "#i18n";
import {useProjectsStore} from "~/stores/projects.ts";
import ProjectList from "~/src/components/ProjectList/ProjectList.vue";

// i18
const i18nPrefix = "pages.Projects"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const {projects} = toRefs(useProjectsStore())

useProjectsStore().get()

defineI18nRoute({
  paths: {
    'en': '/projects',
    'de': '/projects',
    'es': '/projects',
    'fr': '/projects',
    'it': '/projects',
    'pt': '/projects',
    'zh': '/projects',
    'ja': '/projects',
    'ko': '/projects',
    'ru': '/projects',
    'hi': '/projects',
    'pl': '/projects',
    'cs': '/projects',
  }
})

</script>

<style>
@import "./style.scss";
</style>