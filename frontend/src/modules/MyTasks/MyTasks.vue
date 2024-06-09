<template>
  <div class="my-tasks-module mt-module">
    <div class="h1">
      Мои задачи
    </div>
    <div class="mt-module__task-list">
      <puzzle-task-list v-if="tasks" v-model="tasks" @click:task="selectTask"/>
    </div>
    <fridge v-model:state="fridgeState">
      <task-card v-model="task"/>
    </fridge>
  </div>
</template>

<script setup lang='ts'>
import {useDefaultState} from './composables/useDefault'
import GetUserTasks from "~/api/endpoints/tasks/GetUserTasks";
import {useUserStore} from "~/stores/user";
import PuzzleTaskList from "~/src/components/PuzzleTaskList/PuzzleTaskList.vue";
import type {Task} from "~/types/Common";
import {useFridge} from "~/src/components/Fridge/composables/useFridge";
import Fridge from "~/src/components/Fridge/Fridge.vue";
import TaskCard from "~/src/components/TaskCard/TaskCard.vue";

const ctx = useDefaultState()

// i18
const i18nPrefix = "modules.MyTasks"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const tasks = await new GetUserTasks({
  current: true
}).request(useUserStore().user?.id)
const task: Ref<Task | null> = ref(null)
const fridgeState = ref(false)

function selectTask(item: Task) {
  task.value = item
  fridgeState.value = true
}

</script>

<style lang="scss">
@import "./style.scss";
</style>