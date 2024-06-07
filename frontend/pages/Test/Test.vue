<template>
  <div class="test-page">
    <div class="page-content container">
      <puzzle-task-list v-model="tasks" class="flex-grow-1" @click:task="(task) => { console.log(task) }"/>
<!--      <div class="flex items-center">-->
<!--      </div>-->
    </div>
  </div>
</template>

<script setup lang="ts">
import {defineI18nRoute} from "#i18n";
import PuzzleTask from "~/src/components/PuzzleTask/PuzzleTask.vue";
import PuzzleTaskList from "~/src/components/PuzzleTaskList/PuzzleTaskList.vue";
import GetTasks from "~/api/endpoints/tasks/GetTasks";

// i18
const i18nPrefix = "pages.Test"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const tasks = (await new GetTasks().request()).value.slice(1,20)

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