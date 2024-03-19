<template>
  <div :class="commonClass">
    <div v-show="ctx.isOpen" class="modal__wrapper">
      <div :class="props.class" class="modal" :style="props.style">
        <div class="modal__header">
          <slot v-if="!!$slots.title" name="title"/>
          <div v-else class="modal__header_empty">

          </div>
          <div @click="ctx.isOpen = false; $emit('close')" class="modal__esc"/>
        </div>
        <div class="modal__content">
          <slot v-if="!!$slots.default"/>
          <div v-else class="modal__content_empty"></div>
        </div>
      </div>
    </div>
    <div @click="ctx.isOpen = true" class="modal__action">
      <slot v-if="!!$slots.action" name="action"/>
      <div v-else class="a a_blue a_inner modal__action_empty">
        {{ ctx.isOpen }}
        [action]
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.Modal"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const props = defineProps<{
  class?: string,
  commonClass?: string,
  style?: Partial<CSSStyleDeclaration>
}>()

const emits = defineEmits<{
  close: []
}>()
</script>

<style lang="scss">
@import "./style.scss";
</style>