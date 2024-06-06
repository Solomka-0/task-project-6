<template>
  <div ref="mainRef" class=puzzle-tile>
    <component ref="tileRef" class="puzzle" :class="{
      'top-0': props.tile.top == 0 || props.tile.top == 2,
      'left-0': props.tile.left == 0 || props.tile.left == 2,
      'right-0': props.tile.right == 0 || props.tile.right == 2,
      'bottom-0': props.tile.bottom == 0 || props.tile.bottom == 2
    }" :is="tile">
    </component>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
const ctx = useDefaultState()

const props = defineProps<{
  tile: {
    left: number,
    top: number,
    right: number,
    bottom: number,
  }
}>()
const getTile = () => defineAsyncComponent(() => import(`public/ui/puzzles/tile_${props.tile.left}_${props.tile.top}_${props.tile.right}_${props.tile.bottom}.svg?component`));
const tile = shallowRef(getTile())


// i18
const i18nPrefix = "components.PuzzleTile"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const tileRef = ref(null)
const mainRef = ref(null)
const gradientRef = ref(null)
const color = ref<string | null>(null)

function initColor() {
  const main = mainRef.value
  let bgColor = window.getComputedStyle(main!).backgroundColor
  if (bgColor.match(/\(.*,.*,.*\)/)) {
    main!.style.backgroundColor = bgColor.replace(')', ',0)').replace('rgb(', 'rgba(')
    bgColor = bgColor.replace(')', ',0)').replace('rgb(', 'rgba(')
  }
  const match = bgColor.match(/\((.*),(.*),(.*),/)
  color.value = `rgb(${match![1]},${match![2]},${match![3]})`
}

onMounted( async () => {
  initColor()
})

</script>

<style lang="scss">
@import "./style.scss";

path, g > rect {
  fill: v-bind(color) !important;
  stroke: v-bind(color);
}
</style>