<template>
  <div class="project-page">
    <div class="page-content container">
      <project-card v-if="project" v-model="project"/>
    </div>
  </div>
</template>

<script setup="ts">
import {defineI18nRoute} from "#i18n";
import ProjectCard from "~/src/components/ProjectCard/ProjectCard.vue";
import {useProjectsStore} from "~/stores/projects.ts";

// i18
const i18nPrefix = "pages.Project"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const route = useRoute()

useProjectsStore().get(route.params.id)

const {project} = toRefs(useProjectsStore())

defineI18nRoute({
  paths: {
    'en': '/project/[id]',
    'de': '/project/[id]',
    'es': '/project/[id]',
    'fr': '/project/[id]',
    'it': '/project/[id]',
    'pt': '/project/[id]',
    'zh': '/project/[id]',
    'ja': '/project/[id]',
    'ko': '/project/[id]',
    'ru': '/project/[id]',
    'hi': '/project/[id]',
    'pl': '/project/[id]',
    'cs': '/project/[id]',
  }
})

</script>

<style>
@import "./style.scss";
</style>