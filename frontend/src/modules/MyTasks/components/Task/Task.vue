<template>
  <div class=task :style="{
  '--bg-default': props.style ?? styles[task?.status],
  }">
    <div class="task__dec task__dec_top"/>
    <div class="task__dec task__dec_bottom"/>
    <div class="task__dec task__dec_left"/>
    <div class="task__dec task__dec_right"/>
    <div class="task__body" :class="{'justify-center': !task.description}">
      <div class="task__caption">
        {{ task.name }}
      </div>
      <div v-if="!!task.description" class="task__description">
        {{ task.description }}
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import {useDefaultState} from './composables/useDefault'
import type {Task} from "~/types/Common";
import {taskStatusesPalette} from "~/types/Common";

const ctx = useDefaultState()

const styles = taskStatusesPalette

const props = defineProps({
  style: {required: false, type: String}
})

// i18
const i18nPrefix = "components.Task"
const nuxtApp = useNuxtApp()
const model = defineModel<Task>('task')
const $i = nuxtApp.$i(i18nPrefix)

</script>

<style lang="scss">
@import "./style.scss";
</style>