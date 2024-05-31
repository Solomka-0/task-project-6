<template>
  <div class="profile-page">
    <div class="page-content container">
      <profile-card v-model="user"/>
      <project-list/>
    </div>
  </div>
</template>

<script setup="ts">
import {defineI18nRoute} from "#i18n";
import ProfileCard from "~/src/components/ProfileCard/ProfileCard.vue";
import {useUserStore} from "~/stores/user.ts";
import ProjectList from "~/src/components/ProjectList/ProjectList.vue";
import {useUsersStore} from "~/stores/users.ts";

// i18
const i18nPrefix = "pages.Profile"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)
const route = useRoute()

if (route.params.id) {
  await useUsersStore().get(route.params.id)
}

const user = route.params.id ? useUsersStore().user : useUserStore().user

defineI18nRoute({
  paths: {
    'en': '/profile/[id]',
    'de': '/profile/[id]',
    'es': '/profile/[id]',
    'fr': '/profile/[id]',
    'it': '/profile/[id]',
    'pt': '/profile/[id]',
    'zh': '/profile/[id]',
    'ja': '/profile/[id]',
    'ko': '/profile/[id]',
    'ru': '/profile/[id]',
    'hi': '/profile/[id]',
    'pl': '/profile/[id]',
    'cs': '/profile/[id]',
  }
})

</script>

<style>
@import "./style.scss";
</style>