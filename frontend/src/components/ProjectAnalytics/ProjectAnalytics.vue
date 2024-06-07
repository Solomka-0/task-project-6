<template>
  <div class=project-analytics>
    <div>
      <bar-chart :chart-data="chartData" :height="250"/>
    </div>
    <div class="flex gap-2">
      <div class="project-analytics__time">
        <img src="/svg/analytics/startup.svg"/>
        <div class="project-analytics__time-value">{{ project!.analytics.time.full }} ч.</div>
        <div class="project-analytics__hint">
          С начала
        </div>
      </div>
      <div class="project-analytics__time" @click="selectChart('month')">
        <img src="/svg/analytics/month.svg"/>
        <div class="project-analytics__time-value">{{ project!.analytics.time.last_month }} ч.</div>
        <div class="project-analytics__hint">
          За месяц
        </div>
      </div>
      <div class="project-analytics__time" @click="selectChart('week')">
        <img src="/svg/analytics/calendar.svg"/>
        <div class="project-analytics__time-value">{{ project!.analytics.time.last_week }} ч.</div>
        <div class="project-analytics__hint">
          За неделю
        </div>
      </div>
      <div class="project-analytics__time" @click="selectChart('day')">
        <img src="/svg/analytics/sun.svg"/>
        <div class="project-analytics__time-value">{{ project!.analytics.time.last_day }} ч.</div>
        <div class="project-analytics__hint">
          За день
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import { useDefaultState } from './composables/useDefault'
import type {Project} from "~/types/Common";
import {BarChart, LineChart} from "vue-chart-3";
const ctx = useDefaultState()

// i18
const i18nPrefix = "components.ProjectAnalytics"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const project = defineModel<Project>()

const chartData = ref({
  labels: [],
  datasets: [{
    label: "Часы",
    backgroundColor: "#54b300",
    data: []
  }]
})

function selectChart(type: string = 'week') {
  chartData.value.labels = Object.keys(project.value!.analytics.chart[type])
  chartData.value.datasets[0].data = Object.values(project.value!.analytics.chart[type])
  console.log(chartData.value.labels)
}

onMounted(() => {
  selectChart()
})
</script>

<style lang="scss">
@import "./style.scss";
</style>