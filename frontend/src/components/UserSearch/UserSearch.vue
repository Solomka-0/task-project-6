<template>
  <div class=user-search>
    <f-input name="search" v-model="search" @focusin="ctx.focus = true" @focusout="ctx.focus = false"/>
    <div class="user-search__results" :class="{'hidden': !ctx.focus}">
      <users-list v-model="results" type="results" @click:user="onSelect"/>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import FInput from "~/src/components/FInput/FInput.vue";
import type {User} from "~/types/Common";
import {useSearchPending} from "~/composables/useSearchPending";
import {useUsersStore} from "~/stores/users";
import UsersList from "~/src/components/UsersList/UsersList.vue";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.UserSearch"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const {results} = toRefs(useUsersStore())
const searchPending = useSearchPending(300)
const search = ref('')
const selected = defineModel<User | undefined>()

watch(search, () => {
  searchPending.pending(з)
})

function onSelect(user: User) {
  selected.value = user
}
</script>

<style lang="scss">
@import "./style.scss";
</style>