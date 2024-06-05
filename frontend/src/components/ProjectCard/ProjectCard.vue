<template>
  <div class=project-card>
    <div class="project-card__name">{{ project!.name }}</div>
    <div class="project-card__description">{{ project!.description }}</div>
    <div class="project-card__items">
      <div class="project-card__users-bar">
        <div class="project-card__users-label">Команда</div>
        <div class="project-card__users">
          <users-list v-model="project!.users" type="cards"/>
        </div>
      </div>
      <div class="project-card__tasks-bar">
        <div class="project-card__tasks-label">Текущие задачи</div>
      </div>
      [Вывод задач]
<!--      {{ project!.tasks }}-->
<!--      <div class="project__tasks-bar">-->
<!--        <div class="project__tasks-label" @click="ctx.tasksState = !ctx.tasksState">Приоритетные задачи</div>-->
<!--        <div v-if="ctx.tasksState" class="project__tasks">-->
<!--          <div v-for="task in project!.tasks.slice(0, 3)">-->
<!--            {{ task.name }}-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import type {Project} from "~/types/Common";
import UsersList from "~/src/components/UsersList/UsersList.vue";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.ProjectCard"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const project = defineModel<Project>()
</script>

<style lang="scss">
@import "./style.scss";
</style>