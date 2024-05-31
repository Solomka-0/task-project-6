<template>
  <div class=users-list>
    <div v-if="props.type === Type.RESULTS" class=users-list__item v-for="user in users" @click="$emit('click:user', user)">
      <div class="users-list__name">{{ user.name }}</div>
      <div class="users-list__email">{{ user.email }}</div>
    </div>
    <nuxt-link v-else :to="localePath({
    name: $getPageName('Profile'),
    params: {
      id: user.id
    }
    })" class=users-list__item v-for="user in users">
      <div class="users-list__name">{{ user.name }}</div>
      <div class="users-list__email">{{ user.email }}</div>
    </nuxt-link>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import type {User} from "~/types/Common";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.UsersList"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

enum Type {
  RESULTS = 'results'
}

defineEmits(["click:user"])

function onClick() {

}

const localePath = useLocalePath()
const users = defineModel<User[]>()
const props = defineProps<{
  type?: Type | string
}>()
</script>

<style lang="scss">
@import "./style.scss";
</style>