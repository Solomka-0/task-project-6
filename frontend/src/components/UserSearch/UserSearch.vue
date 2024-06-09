<template>
  <div class=user-search>
    <f-input name="search" v-model="search" @focusin="ctx.focus = true" @focusout="focusout"/>
    <div v-show="ctx.focus" class="user-search__results">
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
const search = defineModel<string>('search')
const selected = defineModel<User | undefined>()

watch(search, () => {
  searchPending.pending(async () => {
    if (!!search.value) {
      await useUsersStore().usersLike(search.value)
    }
  })
})

function focusout() {
  setTimeout(() => ctx.value.focus = false, 200)
}

function onSelect(user: User) {
  selected.value = user
  search.value = user.name
}

onMounted(async () => {
  if (!!search.value) {
    await useUsersStore().usersLike(search.value)
  }
})
</script>

<style lang="scss">
@import "./style.scss";
</style>