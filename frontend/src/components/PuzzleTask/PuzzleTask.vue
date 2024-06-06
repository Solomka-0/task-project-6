<template>
  <div ref="mainRef" class=puzzle-task>
    <puzzle-tile class="bg-red-500" :tile="props.tile"/>
    <div class="puzzle-task__caption">
      {{ task?.name }}
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import PuzzleTile from "~/src/components/PuzzleTile/PuzzleTile.vue";
import type {Task} from "~/types/Common";
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