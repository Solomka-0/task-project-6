<template>
  <div class=header>
    <div class="container">
      <div class="header__content">
        <nuxt-link to="/" class="header__logo">
          <logo/>
          <div class="header__logo-text">
            <div class="header__logo-caption">
              TaskSolver
            </div>
            <div class="header__logo-description">
              Лучший примитивный менеджер для ваших задач!
            </div>
          </div>
        </nuxt-link>
      </div>
      <div class="header__nav">
        <nuxt-link :to="item.path" v-for="item in nav"
                   class="header__nav-item"
                   :class="{'header__nav-item_active': item.path === router.currentRoute.value.path}">
          {{ item.caption }}
        </nuxt-link>
        <div class="flex-1"></div>
        <nuxt-link to="/login" class="header__logout header__nav-item" @click="ctx.logout">
          {{ !!useUserStore().user ? 'Выход' : 'Войти' }}
        </nuxt-link>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import Home from "~/pages/Home/Home.vue";
import Logo from "~/src/components/Logo/Logo.vue";
import {useUserStore} from "../../../stores/user";

// i18
const i18nPrefix = "components.Header"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const localePath = useLocalePath()
const getPageName: Function = nuxtApp.$getPageName

const ctx = useDefaultState()

type NavItem = {
  caption: string,
  path: string,
}

const nav: NavItem[] = [
  {
    caption: "Главная",
    path: localePath(getPageName('Home'))
  },
  {
    caption: "Проекты",
    path: localePath(getPageName('Projects'))
  },
  {
    caption: "Задачи",
    path: localePath(getPageName('Tasks'))
  }
]

const router = useRouter()
</script>

<style lang="scss">
@import "./style.scss";
</style>