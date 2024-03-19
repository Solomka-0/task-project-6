<template>
  <div class=footer>
    <div class="container">
      <div class="footer__content">
        <div class="footer__copymark">
          <div class="footer__logo">
            <img src="/logos/M.png"/>
          </div>
          <div class="footer__copymark-text">
            <span>© 2024 Под авторством</span><span class="footer__copymark-name">аксима Красюка</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.Footer"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)
</script>

<style lang="scss">
@import "./style.scss";
</style>