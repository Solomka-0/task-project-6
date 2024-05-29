<template>
  <div class="my-tasks-module mt-module">
    <div class="mt-module__headnote">
      <div v-if="!!ctx" class="mt-module__filters inline-flex gap-4 items-center">
        <div class="inline-flex flex-col gap-0">
          <label class="text-[14px] text-gray-600">
            Статус:
          </label>
          <div class="flex gap-2">
            <div v-for="(status, key) in styles" @click="ctx.filters.status = key; setupFilters()" class="task-status" :style="{
              '--status-color': status}">
              {{ key }}
            </div>
          </div>
        </div>
        <div class="">
          <div class="inline-flex flex-col gap-0">
            <label class="text-[14px] text-gray-600">
              Создано не раньше
            </label>
            <input type="datetime-local" v-model="ctx.filters.startFrom" @change="setupFilters">
          </div>
        </div>
        <div class="btn btn_primary" @click="resetFilters">
          Сбросить
        </div>
      </div>
    </div>
    <tasks v-if="!!tasks" v-model:tasks="tasks"/>
  </div>
</template>

<script setup lang='ts'>
import {useDefaultState} from './composables/useDefault'
import Tasks from "~/src/modules/MyTasks/components/Tasks/Tasks.vue";
import GetTasks from "~/api/endpoints/tasks/GetTasks";
import {taskStatusesPalette} from "~/types/Common";

const ctx = useDefaultState()

// i18
const i18nPrefix = "modules.MyTasks"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const styles = taskStatusesPalette

async function resetFilters() {
  ctx.value.filters = {startFrom: undefined, status: undefined}
  tasks.value = (await new GetTasks().request()).value
}

async function setupFilters() {
  let tmp = await new GetTasks({
    status: ctx.value.filters.status,
    startFrom: new Date(ctx.value.filters.startFrom).toUTCString()
  }).request()

  tasks.value = tmp.value
}

const tasks = await new GetTasks().request()

</script>

<style lang="scss">
@import "./style.scss";
</style>