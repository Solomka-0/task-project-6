<template>
  <div class="profile-page">
    <div v-if="user" class="page-content container">
      <profile-card v-model="user"/>
      <div class="mt-[20px]">
        <div class="flex items-center gap-2">
          <div class="h1">Проекты</div>
          <div class="btn btn_green">+</div>
        </div>
        <project-list v-model="user.projects" class="profile-page__projects"/>
      </div>
      <div>
        <div class="flex items-center gap-2 mt-[20px]">
          <div class="h1">Последние задачи</div>
        </div>
        <puzzle-task-list v-model="tasks"/>
      </div>
    </div>
  </div>
</template>

<script setup="ts">
import {defineI18nRoute} from "#i18n";
import ProfileCard from "~/src/components/ProfileCard/ProfileCard.vue";
import {useUserStore} from "~/stores/user.ts";
import ProjectList from "~/src/components/ProjectList/ProjectList.vue";
import {useUsersStore} from "~/stores/users.ts";
import PuzzleTaskList from "~/src/components/PuzzleTaskList/PuzzleTaskList.vue";

// i18
const i18nPrefix = "pages.Profile"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)
const route = useRoute()

useUsersStore().get(route.params.id)

const {user} = route.params.id ? toRefs(useUsersStore()) : toRefs(useUserStore())
const tasks = computed(() => user.value?.tasks.slice(0, 8))

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