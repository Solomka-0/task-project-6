<template>
  <div class=user-analytics>
    <div class="max-w-[700px] w-full">
      <bar-chart :chart-data="chartData" :height="250"/>
    </div>
    <div class="max-w-[700px] w-full flex gap-2">
      <div class="project-analytics__time">
        <img src="/svg/analytics/startup.svg"/>
        <div class="project-analytics__time-value">{{ user!.analytics.full.time.full }} ч.</div>
        <div class="project-analytics__hint">
          С начала
        </div>
      </div>
      <div class="project-analytics__time" @click="selectChart('month')">
        <img src="/svg/analytics/month.svg"/>
        <div class="project-analytics__time-value">{{ user!.analytics.full.time.last_month }} ч.</div>
        <div class="project-analytics__hint">
          За месяц
        </div>
      </div>
      <div class="project-analytics__time" @click="selectChart('week')">
        <img src="/svg/analytics/calendar.svg"/>
        <div class="project-analytics__time-value">{{ user!.analytics.full.time.last_week }} ч.</div>
        <div class="project-analytics__hint">
          За неделю
        </div>
      </div>
      <div class="project-analytics__time" @click="selectChart('day')">
        <img src="/svg/analytics/sun.svg"/>
        <div class="project-analytics__time-value">{{ user!.analytics.full.time.last_day }} ч.</div>
        <div class="project-analytics__hint">
          За день
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import {BarChart} from "vue-chart-3";
import type {Project, User} from "~/types/Common";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.UserAnalytics"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const user = defineModel<User>()

const chartData = ref({
  labels: [],
  datasets: [{
    label: "Часы",
    backgroundColor: "#54b300",
    data: []
  }]
})

function selectChart(type: string = 'week') {
  chartData.value.labels = Object.keys(user.value!.analytics?.full.chart[type])
  chartData.value.datasets[0].data = Object.values(user.value!.analytics?.full.chart[type])
}

onMounted(() => {
  selectChart()
})
</script>

<style lang="scss">
@import "./style.scss";
</style>