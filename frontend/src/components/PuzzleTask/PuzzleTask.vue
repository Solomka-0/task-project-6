<template>
  <div ref="mainRef" class=puzzle-task @click="$emit('click:task', task)">
    <puzzle-tile :style="{backgroundColor: taskStatusesPalette[task?.status]}" :tile="props.tile"/>
    <div class="puzzle-task__caption">
      {{ task?.name }}
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import PuzzleTile from "~/src/components/PuzzleTile/PuzzleTile.vue";
import type {Palette, Task} from "~/types/Common";
const ctx = useDefaultState()

const mainRef = ref()

// i18
const i18nPrefix = "components.PuzzleTask"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const task = defineModel<Task>()

const props = defineProps<{
  tile: {
    left: number,
    top: number,
    right: number,
    bottom: number,
  }
}>()

const {left, top, h, w} = {
  left: props.tile.left != 0 ? '18%' : '28%',
  top: props.tile.top != 0 ? '18%' : "28%",
  w: props.tile.right != 0 ? (props.tile.left != 0 ? "66%" : "56%") : (props.tile.left != 0 ? "56%" : "45%"),
  h: props.tile.bottom != 0 ? (props.tile.top != 0 ? "66%" : "56%") : (props.tile.top != 0 ? "56%" : "45%"),
}

const taskStatusesPalette: Palette = {
  'not started': 'rgb(255 162 162)',
  'in process': '#66a3e1',
  'complete': 'rgb(97 193 82)',
}

defineEmits(["click:task"])

</script>

<style lang="scss">

.puzzle-task {
  &__caption {
    top: v-bind(top);
    left: v-bind(left);
    height: v-bind(h);
    width: v-bind(w);
  }
}

@import "./style.scss";
</style>