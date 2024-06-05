<template>
  <div class=project-list>
    <div class="project" v-for="(project, index) in projects">
      <nuxt-link :to="localePath({
      name: $getPageName('Project'),
      params: {
        id: project.id
      }})"
                 class="project__name">{{ project.name }}</nuxt-link>
      <div class="project__description">{{ project.description }}</div>
      <div class="project__items">
        <div class="project__tasks-bar">
          <div class="project__tasks-label" @click="ctx.tasksState[index] = !ctx.tasksState[index]">Приоритетные задачи</div>
          <div v-if="ctx.tasksState[index]" class="project__tasks">
            <div v-for="task in project.tasks.slice(0, 3)">
              {{ task.name }}
            </div>
          </div>
        </div>
        <div class="project__users-bar">
          <div class="project__users-label" @click="ctx.usersState[index] = !ctx.usersState[index]">Исполнители</div>
          <div v-if="ctx.usersState[index]" class="project__users">
            <div v-for="user in project.users">
              {{ user.name }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import type {Project} from "~/types/Common";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.ProjectList"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const localePath = useLocalePath()

const projects = defineModel<Project[]>()
</script>

<style lang="scss">
@import "./style.scss";
</style>