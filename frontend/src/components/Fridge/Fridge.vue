<template>
  <div class=fridge>
    <div class="fridge__wrapper" :style="{
      'width': state ? '' : '0px'
    }">
      <div class="fridge__content">
        <div class="fridge__header">
          <img src="/svg/right_arrow.svg" class="fridge__curtail-icon" @click="state = !state">
          <div class="fridge__curtail" @click="state = !state">скрыть</div>
        </div>
        <div class="fridge__body">
          <slot/>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import type {Ref} from "@vue/reactivity";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.Fridge"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const state = defineModel<boolean>('state')

</script>

<style lang="scss">
@import "./style.scss";
</style>