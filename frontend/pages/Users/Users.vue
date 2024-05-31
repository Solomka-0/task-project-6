<template>
  <div class="users-page">
    <div class="page-content container">
      <users-list v-model="users"/>
    </div>
  </div>
</template>

<script setup="ts">
import {defineI18nRoute} from "#i18n";
import UsersList from "~/src/components/UsersList/UsersList.vue";
import {useUsersStore} from "~/stores/users.ts";

// i18
const i18nPrefix = "pages.Users"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)
const { users } = toRefs(useUsersStore())

await useUsersStore().get()

defineI18nRoute({
  paths: {
    'en': '/users',
    'de': '/users',
    'es': '/users',
    'fr': '/users',
    'it': '/users',
    'pt': '/users',
    'zh': '/users',
    'ja': '/users',
    'ko': '/users',
    'ru': '/users',
    'hi': '/users',
    'pl': '/users',
    'cs': '/users',
  }
})

</script>

<style>
@import "./style.scss";
</style>