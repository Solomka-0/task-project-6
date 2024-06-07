<template>
  <div class=project-card>
    <div class="flex gap-2 items-center">
      <img :src="`/logos/projects/${project.id}.png`" class="project-card__logo">
      <div class="flex flex-col justify-center gap-2">
        <div class="project-card__name">{{ project!.name }}</div>
        <div class="project-card__description">{{ project!.description }}</div>
      </div>
    </div>
    <div v-if="project!.analytics" class="project-card__analytics">
      <project-analytics v-model="project"/>
    </div>
    <div class="project-card__items">
      <div class="project-card__users-bar">
        <div class="project-card__users-label">Команда</div>
        <div class="project-card__users">
          <users-list v-model="project!.users" type="cards"/>
        </div>
      </div>
      <div class="project-card__tasks-bar">
        <div class="project-card__tasks-label">Текущие задачи</div>
        <div>
          <puzzle-task-list v-model="tasks"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import type {Project} from "~/types/Common";
import UsersList from "~/src/components/UsersList/UsersList.vue";
import ProjectAnalytics from "~/src/components/ProjectAnalytics/ProjectAnalytics.vue";
import PuzzleTaskList from "~/src/components/PuzzleTaskList/PuzzleTaskList.vue";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.ProjectCard"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const tasks = computed(() => {
  // console.log(project)
  return project.value!.tasks.slice(0, 30)
})
const project = defineModel<Project>()
</script>

<style lang="scss">
@import "./style.scss";
</style>