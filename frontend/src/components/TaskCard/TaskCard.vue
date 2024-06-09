<template>
  <div v-if="!!task" class=task-card>
    <div class="flex items-center gap-2">
      <div class="task-card__priority flex items-center gap-2" :style="{borderColor: priority[task?.priority]?.color}">
        <div class="task-card__priority-point" :style="{backgroundColor: priority[task?.priority]?.color}"/>
        <div class="task-card__priority-name">
          {{ priority[task?.priority]?.name }}
        </div>
      </div>
      <div class="task-card__status" :style="{backgroundColor: status[task?.status]?.color}">{{ status[task?.status]?.name }}</div>
    </div>
    <div class="task-card__name h1">{{ task?.name }}</div>
    <div class="task-card__description">{{ task?.description }}</div>
    <div class="flex items-center gap-1 pr-4 relative">
      <user-search class="task-card__user" :search="user?.name"/>
      <div class="task-card__created-at flex-1">
        <img src="/svg/analytics/calendar.svg" class="max-h-[20px]">
        <div class="task-card__value">{{ new Date(task!.created_at).toLocaleDateString() }}</div>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import type {Task} from "~/types/Common";
import {priority, status} from "./common";
import FInput from "~/src/components/FInput/FInput.vue";
import UserSearch from "~/src/components/UserSearch/UserSearch.vue";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.TaskCard"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const task = defineModel<Task>()
const user = computed(() => {
  return task.value?.user ?  task.value?.user[0] : null
})
</script>

<style lang="scss">
@import "./style.scss";
</style>