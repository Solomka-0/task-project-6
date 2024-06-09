<template>
  <div class=project-list>
    <div class="project" v-for="(project, index) in projects">
      <img src="/svg/bookmark.svg" class="project__bookmark" @click="states[index] = !states[index]">
      <div class="flex gap-2 cursor-pointer" @click="states[index] = !states[index]">
        <img :src="`/logos/projects/${project.id}.png`" class="max-h-[64px]"/>
        <div>
          <nuxt-link :to="localePath({
          name: $getPageName('Project'),
          params: {
          id: project.id
        }})" class="project__name">
            {{ project.name }}
          </nuxt-link>
          <div class="project__description">{{ project.description }}</div>
        </div>
      </div>
      <div v-if="states[index]">
        <puzzle-task-list :model-value="project.tasks.slice(0, 5)" @click:task="item => {task = item; taskState = true}"/>
      </div>
    </div>
    <fridge v-model:state="taskState">
      <task-card v-model="task"/>
    </fridge>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import type {Project} from "~/types/Common";
import PuzzleTaskList from "~/src/components/PuzzleTaskList/PuzzleTaskList.vue";
import Fridge from "~/src/components/Fridge/Fridge.vue";
import TaskCard from "~/src/components/TaskCard/TaskCard.vue";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.ProjectList"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const localePath = useLocalePath()

const states = ref([])
const projects = defineModel<Project[]>()
const taskState = ref(false)
const task = ref(null)

</script>

<style lang="scss">
@import "./style.scss";
</style>