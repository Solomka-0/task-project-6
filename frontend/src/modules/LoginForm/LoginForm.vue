<template>
  <div class=login-form>
    <f-input name="email" v-model="ctx.form.email" label-text="Почта" required/>
    <f-input name="email" v-model="ctx.form.password" type="password" label-text="Пароль" required/>
    <div class="login-form__footnote">
      <div class="btn btn_primary" @click="submit">
        Войти
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import {useDefaultState} from './composables/useDefault'
import FInput from "~/src/components/FInput/FInput.vue";

const ctx = useDefaultState()
const {submit} = ctx.value

// i18
const i18nPrefix = "modules.LoginForm"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)
</script>

<style lang="scss">
@import "./style.scss";
</style>