<template>
  <div class="home-page">
    <div class="page-content container">
      <div>
        <div class="h1">Текущие проекты</div>
        <div>
          <div v-for="project in user.projects" class="flex flex-col gap-2">
            <div class="project">
              <img :src="`/logos/projects/${project.id}.png`" class="max-h-[64px]"/>
              <div>
                <nuxt-link :to="localePath({
                name: $getPageName('Project'),
                params: {
                  id: project.id
                }})" class="project__name" target="_blank">
                  {{ project.name }}
                </nuxt-link>
                <div class="project__description">{{ project.description }}</div>
              </div>
            </div>
            <div class="tasks">
              <puzzle-task-list :model-value="project.tasks.filter(item => item.user_id === user.id).slice(0, 5)" @click:task="item => {task = item; taskState = true}"/>
            </div>
          </div>
        </div>
      </div>
      <fridge v-model:state="taskState">
        <task-card v-model="task"/>
      </fridge>
    </div>
  </div>
</template>

<script setup="ts">
import {defineI18nRoute} from "#i18n";
import {useProjectsStore} from "~/stores/projects.ts";
import {useUsersStore} from "~/stores/users.ts";
import {useUserStore} from "~/stores/user.ts";
import PuzzleTaskList from "~/src/components/PuzzleTaskList/PuzzleTaskList.vue";
import Fridge from "~/src/components/Fridge/Fridge.vue";
import TaskCard from "~/src/components/TaskCard/TaskCard.vue";


// i18
const i18nPrefix = "pages.Home"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

await useUsersStore().get(useUserStore().user.id)
// await useProjectsStore().get()

const {user} = toRefs(useUsersStore())
console.log(user.value)
const tasks = ref(user.value.tasks.slice(0, 8))
const task = ref(null)
const taskState = ref(false)

defineI18nRoute({
  paths: {
    'en': '/',
    'de': '/',
    'es': '/',
    'fr': '/',
    'it': '/',
    'pt': '/',
    'zh': '/',
    'ja': '/',
    'ko': '/',
    'ru': '/',
    'hi': '/',
    'pl': '/',
    'cs': '/',
  }
})

</script>

<style>
@import "./style.scss";
</style>