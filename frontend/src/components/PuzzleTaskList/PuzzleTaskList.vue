<template>
  <div ref="mainRef" class="puzzle-task-list">
    <div v-if="tiles.length > 0">
      <puzzle-task :tile="tiles[index]" v-model="tasks[index]" v-for="(tile, index) in tiles" :class="{'invisible' : !tasks[index]}" @click:task="(task) => $emit('click:task', task)"/>
    </div>
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
const invisibleRef = ref(null)
const colSize = ref(0)
const rowSize = ref(0)
const count = ref(0)
const tiles = ref([])


function render()
{
  function tile(rowIndex, colIndex, topValue = null, leftValue = null)
  {
    function getRandomInt(min: number, max: number) {
      min = Math.ceil(min);
      max = Math.floor(max);
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    return {
      left: leftValue ? 1 - leftValue.right : 2,
      top: topValue ? 1 - topValue.bottom : 2,
      right: colIndex === colSize.value - 1 ? 2 : getRandomInt(0, 1),
      bottom: rowIndex === rowSize.value - 1 ? 2 : getRandomInt(0, 1),
    }
  }

  let row: {left: 1, top: 0, right: 1, bottom: 0}[] = []
  let tmpRow: {left: 1, top: 0, right: 1, bottom: 0}[] = []
  let item = null

  for(let i = 0; i < rowSize.value; i++) {
    // Сравнение с предыдущей строкой
    for(let j = 0; j < colSize.value; j++) {
      item = tile(i, j, row[j], tmpRow[j - 1])
      tmpRow.push(item)
      tiles.value.push(item)
    }
    row = tmpRow
    tmpRow = []
  }
}

function getSizes() {
  let width = window.getComputedStyle(mainRef.value).width
  width = parseInt(width.match(/(\w*).*px/)[1])
  colSize.value = Math.ceil(width > 330 ? (width > 440 ? width / 200 : width / 230) : 1)
  rowSize.value = Math.ceil(tasks.value?.length / colSize.value)
}

onMounted(() => {
  getSizes()
  render()
})

defineEmits(["click:task"])

</script>

<style lang="scss">
@import "./style.scss";
</style>