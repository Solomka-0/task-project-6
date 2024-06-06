<template>
  <div ref="mainRef" class=puzzle-task-list>
    <puzzle-task :tile="{left: 1, top: 0, right: 1, bottom: 0}" v-model="tasks[index]" v-for="(task, index) in tasks"/>
    <puzzle-task :tile="{left: 2, top: 2, right: 2, bottom: 2}" v-for="index in count" class="invisible"/>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import PuzzleTask from "~/src/components/PuzzleTask/PuzzleTask.vue";
import type {Task} from "~/types/Common";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.PuzzleTaskList"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const tasks = defineModel<Task[]>()
const mainRef = ref(null)
const colSize = ref(0)
const rowSize = ref(0)
const count = ref(0)
const tiles = reactive([])

function render()
{
  function getRandomArbitrary(min, max) {
    return Math.random() * (max - min) + min;
  }

  let childs: HTMLCollection = mainRef.value.children

  let bounds = <{tl:any, tr:any, bl:any, br:any,}>{
    tl: null,
    tr: null,
    bl: null,
    br: null,
  }

  bounds.tl = childs[0].getBoundingClientRect();
  bounds.br = childs[childs.length - 1].getBoundingClientRect();

  rowSize.value = parseInt(childs.length / colSize.value)
  console.log(colSize.value, rowSize.value)

  let tile = {
    left: 1,
    top: 0,
    right: 1,
    bottom: 0
  }

  for(let j = 0; j < rowSize.value; j++) {
    for(let i = 0; i < colSize.value; i++) {
      if (j === 0) {
        tile.top = 2
      } else {
        tile.top = 0
      }

      if (i === 0) {
        tile.left = 2
      } else {
        tile.left = 0
      }

      if (i === colSize.value - 1) {
        tile.right = 2
      } else {
        tile.right = 0
      }

      if (j === rowSize.value - 1) {
        tile.bottom = 2
      } else {
        tile.bottom = 0
      }

      tiles.push(tile)
    }
  }
  console.log(tiles)
}

function computeInvisibleCount()
{
  let width = window.getComputedStyle(mainRef.value).width
  width = Number.parseInt(width.match(/(\w*).*px/)[1])
  colSize.value = Math.round(width / 200 + 0.13)
  count.value = width == 1 ? 0 : width - tasks.value?.length % width
}

onMounted(() => {
  computeInvisibleCount()
  render()
})
</script>

<style lang="scss">
@import "./style.scss";
</style>