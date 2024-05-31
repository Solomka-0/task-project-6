<template>
  <div class=profile-card>
    <img src="/ui/icons/profile/user.svg" class="w-[100px]">
    <div>
      <div class="profile-card__name">{{ user!.name }}</div>
      <div class="profile-card__email">{{ user!.email }}</div>
      <div class="profile-card__rules">{{ Rule[user!.rules[0] as keyof typeof Rule] }}</div>
      <div class="profile-card__created-at">
        <div class="profile-card__label">Дата регистрации:</div>
        <div class="profile-card__value">{{ new Date(user!.created_at).toLocaleDateString() }}</div>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import {Rule, type User} from "~/types/Common";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.ProfileCard"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const user = defineModel<User>()
</script>

<style lang="scss">
@import "./style.scss";
</style>